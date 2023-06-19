/* eslint-disable no-console */
'use strict';

// istanbul ignore next

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj['default'] = obj; return newObj; } }

// istanbul ignore next

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _async = require('async');

var _async2 = _interopRequireDefault(_async);

var _fs = require('fs');

var _fs2 = _interopRequireDefault(_fs);

var _handlebars = require('./handlebars');

var Handlebars = _interopRequireWildcard(_handlebars);

var _path = require('path');

var _sourceMap = require('source-map');

var _uglifyJs = require('uglify-js');

var _uglifyJs2 = _interopRequireDefault(_uglifyJs);

module.exports.loadTemplates = function (opts, callback) {
  loadStrings(opts, function (err, strings) {
    if (err) {
      callback(err);
    } else {
      loadFiles(opts, function (err, files) {
        if (err) {
          callback(err);
        } else {
          opts.templates = strings.concat(files);
          callback(undefined, opts);
        }
      });
    }
  });
};

function loadStrings(opts, callback) {
  var strings = arrayCast(opts.string),
      names = arrayCast(opts.name);

  if (names.length !== strings.length && strings.length > 1) {
    return callback(new Handlebars.Exception('Number of names did not match the number of string inputs'));
  }

  _async2['default'].map(strings, function (string, callback) {
    if (string !== '-') {
      callback(undefined, string);
    } else {
      (function () {
        // Load from stdin
        var buffer = '';
        process.stdin.setEncoding('utf8');

        process.stdin.on('data', function (chunk) {
          buffer += chunk;
        });
        process.stdin.on('end', function () {
          callback(undefined, buffer);
        });
      })();
    }
  }, function (err, strings) {
    strings = strings.map(function (string, index) {
      return {
        name: names[index],
        path: names[index],
        source: string
      };
    });
    callback(err, strings);
  });
}

function loadFiles(opts, callback) {
  // Build file extension pattern
  var extension = (opts.extension || 'handlebars').replace(/[\\^$*+?.():=!|{}\-\[\]]/g, function (arg) {
    return '\\' + arg;
  });
  extension = new RegExp('\\.' + extension + '$');

  var ret = [],
      queue = (opts.files || []).map(function (template) {
    return { template: template, root: opts.root };
  });
  _async2['default'].whilst(function () {
    return queue.length;
  }, function (callback) {
    var _queue$shift = queue.shift();

    var path = _queue$shift.template;
    var root = _queue$shift.root;

    _fs2['default'].stat(path, function (err, stat) {
      if (err) {
        return callback(new Handlebars.Exception('Unable to open template file "' + path + '"'));
      }

      if (stat.isDirectory()) {
        opts.hasDirectory = true;

        _fs2['default'].readdir(path, function (err, children) {
          /* istanbul ignore next : Race condition that being too lazy to test */
          if (err) {
            return callback(err);
          }
          children.forEach(function (file) {
            var childPath = path + '/' + file;

            if (extension.test(childPath) || _fs2['default'].statSync(childPath).isDirectory()) {
              queue.push({ template: childPath, root: root || path });
            }
          });

          callback();
        });
      } else {
        _fs2['default'].readFile(path, 'utf8', function (err, data) {
          /* istanbul ignore next : Race condition that being too lazy to test */
          if (err) {
            return callback(err);
          }

          if (opts.bom && data.indexOf('﻿') === 0) {
            data = data.substring(1);
          }

          // Clean the template name
          var name = path;
          if (!root) {
            name = _path.basename(name);
          } else if (name.indexOf(root) === 0) {
            name = name.substring(root.length + 1);
          }
          name = name.replace(extension, '');

          ret.push({
            path: path,
            name: name,
            source: data
          });

          callback();
        });
      }
    });
  }, function (err) {
    if (err) {
      callback(err);
    } else {
      callback(undefined, ret);
    }
  });
}

module.exports.cli = function (opts) {
  if (opts.version) {
    console.log(Handlebars.VERSION);
    return;
  }

  if (!opts.templates.length && !opts.hasDirectory) {
    throw new Handlebars.Exception('Must define at least one template or directory.');
  }

  if (opts.simple && opts.min) {
    throw new Handlebars.Exception('Unable to minimize simple output');
  }

  var multiple = opts.templates.length !== 1 || opts.hasDirectory;
  if (opts.simple && multiple) {
    throw new Handlebars.Exception('Unable to output multiple templates in simple mode');
  }

  // Force simple mode if we have only one template and it's unnamed.
  if (!opts.amd && !opts.commonjs && opts.templates.length === 1 && !opts.templates[0].name) {
    opts.simple = true;
  }

  // Convert the known list into a hash
  var known = {};
  if (opts.known && !Array.isArray(opts.known)) {
    opts.known = [opts.known];
  }
  if (opts.known) {
    for (var i = 0, len = opts.known.length; i < len; i++) {
      known[opts.known[i]] = true;
    }
  }

  var objectName = opts.partial ? 'Handlebars.partials' : 'templates';

  var output = new _sourceMap.SourceNode();
  if (!opts.simple) {
    if (opts.amd) {
      output.add('define([\'' + opts.handlebarPath + 'handlebars.runtime\'], function(Handlebars) {\n  Handlebars = Handlebars["default"];');
    } else if (opts.commonjs) {
      output.add('var Handlebars = require("' + opts.commonjs + '");');
    } else {
      output.add('(function() {\n');
    }
    output.add('  var template = Handlebars.template, templates = ');
    if (opts.namespace) {
      output.add(opts.namespace);
      output.add(' = ');
      output.add(opts.namespace);
      output.add(' || ');
    }
    output.add('{};\n');
  }

  opts.templates.forEach(function (template) {
    var options = {
      knownHelpers: known,
      knownHelpersOnly: opts.o
    };

    if (opts.map) {
      options.srcName = template.path;
    }
    if (opts.data) {
      options.data = true;
    }

    var precompiled = Handlebars.precompile(template.source, options);

    // If we are generating a source map, we have to reconstruct the SourceNode object
    if (opts.map) {
      var consumer = new _sourceMap.SourceMapConsumer(precompiled.map);
      precompiled = _sourceMap.SourceNode.fromStringWithSourceMap(precompiled.code, consumer);
    }

    if (opts.simple) {
      output.add([precompiled, '\n']);
    } else {
      if (!template.name) {
        throw new Handlebars.Exception('Name missing for template');
      }

      if (opts.amd && !multiple) {
        output.add('return ');
      }
      output.add([objectName, '[\'', template.name, '\'] = template(', precompiled, ');\n']);
    }
  });

  // Output the content
  if (!opts.simple) {
    if (opts.amd) {
      if (multiple) {
        output.add(['return ', objectName, ';\n']);
      }
      output.add('});');
    } else if (!opts.commonjs) {
      output.add('})();');
    }
  }

  if (opts.map) {
    output.add('\n//# sourceMappingURL=' + opts.map + '\n');
  }

  output = output.toStringWithSourceMap();
  output.map = output.map + '';

  if (opts.min) {
    output = _uglifyJs2['default'].minify(output.code, {
      fromString: true,

      outSourceMap: opts.map,
      inSourceMap: JSON.parse(output.map)
    });
  }

  if (opts.map) {
    _fs2['default'].writeFileSync(opts.map, output.map, 'utf8');
  }
  output = output.code;

  if (opts.output) {
    _fs2['default'].writeFileSync(opts.output, output, 'utf8');
  } else {
    console.log(output);
  }
};

function arrayCast(value) {
  value = value != null ? value : [];
  if (!Array.isArray(value)) {
    value = [value];
  }
  return value;
}
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uL2xpYi9wcmVjb21waWxlci5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7OztxQkFDa0IsT0FBTzs7OztrQkFDVixJQUFJOzs7OzBCQUNTLGNBQWM7O0lBQTlCLFVBQVU7O29CQUNDLE1BQU07O3lCQUNlLFlBQVk7O3dCQUNyQyxXQUFXOzs7O0FBRTlCLE1BQU0sQ0FBQyxPQUFPLENBQUMsYUFBYSxHQUFHLFVBQVMsSUFBSSxFQUFFLFFBQVEsRUFBRTtBQUN0RCxhQUFXLENBQUMsSUFBSSxFQUFFLFVBQVMsR0FBRyxFQUFFLE9BQU8sRUFBRTtBQUN2QyxRQUFJLEdBQUcsRUFBRTtBQUNQLGNBQVEsQ0FBQyxHQUFHLENBQUMsQ0FBQztLQUNmLE1BQU07QUFDTCxlQUFTLENBQUMsSUFBSSxFQUFFLFVBQVMsR0FBRyxFQUFFLEtBQUssRUFBRTtBQUNuQyxZQUFJLEdBQUcsRUFBRTtBQUNQLGtCQUFRLENBQUMsR0FBRyxDQUFDLENBQUM7U0FDZixNQUFNO0FBQ0wsY0FBSSxDQUFDLFNBQVMsR0FBRyxPQUFPLENBQUMsTUFBTSxDQUFDLEtBQUssQ0FBQyxDQUFDO0FBQ3ZDLGtCQUFRLENBQUMsU0FBUyxFQUFFLElBQUksQ0FBQyxDQUFDO1NBQzNCO09BQ0YsQ0FBQyxDQUFDO0tBQ0o7R0FDRixDQUFDLENBQUM7Q0FDSixDQUFDOztBQUVGLFNBQVMsV0FBVyxDQUFDLElBQUksRUFBRSxRQUFRLEVBQUU7QUFDbkMsTUFBSSxPQUFPLEdBQUcsU0FBUyxDQUFDLElBQUksQ0FBQyxNQUFNLENBQUM7TUFDaEMsS0FBSyxHQUFHLFNBQVMsQ0FBQyxJQUFJLENBQUMsSUFBSSxDQUFDLENBQUM7O0FBRWpDLE1BQUksS0FBSyxDQUFDLE1BQU0sS0FBSyxPQUFPLENBQUMsTUFBTSxJQUM1QixPQUFPLENBQUMsTUFBTSxHQUFHLENBQUMsRUFBRTtBQUN6QixXQUFPLFFBQVEsQ0FBQyxJQUFJLFVBQVUsQ0FBQyxTQUFTLENBQUMsMkRBQTJELENBQUMs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QUUsSUFBSSxDQUFDLEdBQUc7QUFDdEIsaUJBQVcsRUFBRSxJQUFJLENBQUMsS0FBSyxDQUFDLE1BQU0sQ0FBQyxHQUFHLENBQUM7S0FDcEMsQ0FBQyxDQUFDO0dBQ0o7O0FBRUQsTUFBSSxJQUFJLENBQUMsR0FBRyxFQUFFO0FBQ1osb0JBQUcsYUFBYSxDQUFDLElBQUksQ0FBQyxHQUFHLEVBQUUsTUFBTSxDQUFDLEdBQUcsRUFBRSxNQUFNLENBQUMsQ0FBQztHQUNoRDtBQUNELFFBQU0sR0FBRyxNQUFNLENBQUMsSUFBSSxDQUFDOztBQUVyQixNQUFJLElBQUksQ0FBQyxNQUFNLEVBQUU7QUFDZixvQkFBRyxhQUFhLENBQUMsSUFBSSxDQUFDLE1BQU0sRUFBRSxNQUFNLEVBQUUsTUFBTSxDQUFDLENBQUM7R0FDL0MsTUFBTTtBQUNMLFdBQU8sQ0FBQyxHQUFHLENBQUMsTUFBTSxDQUFDLENBQUM7R0FDckI7Q0FDRixDQUFDOztBQUVGLFNBQVMsU0FBUyxDQUFDLEtBQUssRUFBRTtBQUN4QixPQUFLLEdBQUcsS0FBSyxJQUFJLElBQUksR0FBRyxLQUFLLEdBQUcsRUFBRSxDQUFDO0FBQ25DLE1BQUksQ0FBQyxLQUFLLENBQUMsT0FBTyxDQUFDLEtBQUssQ0FBQyxFQUFFO0FBQ3pCLFNBQUssR0FBRyxDQUFDLEtBQUssQ0FBQyxDQUFDO0dBQ2pCO0FBQ0QsU0FBTyxLQUFLLENBQUM7Q0FDZCIsImZpbGUiOiJwcmVjb21waWxlci5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8qIGVzbGludC1kaXNhYmxlIG5vLWNvbnNvbGUgKi9cbmltcG9ydCBBc3luYyBmcm9tICdhc3luYyc7XG5pbXBvcnQgZnMgZnJvbSAnZnMnO1xuaW1wb3J0ICogYXMgSGFuZGxlYmFycyBmcm9tICcuL2hhbmRsZWJhcnMnO1xuaW1wb3J0IHtiYXNlbmFtZX0gZnJvbSAncGF0aCc7XG5pbXBvcnQge1NvdXJjZU1hcENvbnN1bWVyLCBTb3VyY2VOb2RlfSBmcm9tICdzb3VyY2UtbWFwJztcbmltcG9ydCB1Z2xpZnkgZnJvbSAndWdsaWZ5LWpzJztcblxubW9kdWxlLmV4cG9ydHMubG9hZFRlbXBsYXRlcyA9IGZ1bmN0aW9uKG9wdHMsIGNhbGxiYWNrKSB7XG4gIGxvYWRTdHJpbmdzKG9wdHMsIGZ1bmN0aW9uKGVyciwgc3RyaW5ncykge1xuICAgIGlmIChlcnIpIHtcbiAgICAgIGNhbGxiYWNrKGVycik7XG4gICAgfSBlbHNlIHtcbiAgICAgIGxvYWRGaWxlcyhvcHRzLCBmdW5jdGlvbihlcnIsIGZpbGVzKSB7XG4gICAgICAgIGlmIChlcnIpIHtcbiAgICAgICAgICBjYWxsYmFjayhlcnIpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIG9wdHMudGVtcGxhdGVzID0gc3RyaW5ncy5jb25jYXQoZmlsZXMpO1xuICAgICAgICAgIGNhbGxiYWNrKHVuZGVmaW5lZCwgb3B0cyk7XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH1cbiAgfSk7XG59O1xuXG5mdW5jdGlvbiBsb2FkU3RyaW5ncyhvcHRzLCBjYWxsYmFjaykge1xuICBsZXQgc3RyaW5ncyA9IGFycmF5Q2FzdChvcHRzLnN0cmluZyksXG4gICAgICBuYW1lcyA9IGFycmF5Q2FzdChvcHRzLm5hbWUpO1xuXG4gIGlmIChuYW1lcy5sZW5ndGggIT09IHN0cmluZ3MubGVuZ3RoXG4gICAgICAmJiBzdHJpbmdzLmxlbmd0aCA+IDEpIHtcbiAgICByZXR1cm4gY2FsbGJhY2sobmV3IEhhbmRsZWJhcnMuRXhjZXB0aW9uKCdOdW1iZXIgb2YgbmFtZXMgZGlkIG5vdCBtYXRjaCB0aGUgbnVtYmVyIG9mIHN0cmluZyBpbnB1dHMnKSk7XG4gIH1cblxuICBBc3luYy5tYXAoc3RyaW5ncywgZnVuY3Rpb24oc3RyaW5nLCBjYWxsYmFjaykge1xuICAgICAgaWYgKHN0cmluZyAhPT0gJy0nKSB7XG4gICAgICAgIGNhbGxiYWNrKHVuZGVmaW5lZCwgc3RyaW5nKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIC8vIExvYWQgZnJvbSBzdGRpblxuICAgICAgICBsZXQgYnVmZmVyID0gJyc7XG4gICAgICAgIHByb2Nlc3Muc3RkaW4uc2V0RW5jb2RpbmcoJ3V0ZjgnKTtcblxuICAgICAgICBwcm9jZXNzLnN0ZGluLm9uKCdkYXRhJywgZnVuY3Rpb24oY2h1bmspIHtcbiAgICAgICAgICBidWZmZXIgKz0gY2h1bms7XG4gICAgICAgIH0pO1xuICAgICAgICBwcm9jZXNzLnN0ZGluLm9uKCdlbmQnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICBjYWxsYmFjayh1bmRlZmluZWQsIGJ1ZmZlcik7XG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0sXG4gICAgZnVuY3Rpb24oZXJyLCBzdHJpbmdzKSB7XG4gICAgICBzdHJpbmdzID0gc3RyaW5ncy5tYXAoKHN0cmluZywgaW5kZXgpID0+ICh7XG4gICAgICAgIG5hbWU6IG5hbWVzW2luZGV4XSxcbiAgICAgICAgcGF0aDogbmFtZXNbaW5kZXhdLFxuICAgICAgICBzb3VyY2U6IHN0cmluZ1xuICAgICAgfSkpO1xuICAgICAgY2FsbGJhY2soZXJyLCBzdHJpbmdzKTtcbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gbG9hZEZpbGVzKG9wdHMsIGNhbGxiYWNrKSB7XG4gIC8vIEJ1aWxkIGZpbGUgZXh0ZW5zaW9uIHBhdHRlcm5cbiAgbGV0IGV4dGVuc2lvbiA9IChvcHRzLmV4dGVuc2lvbiB8fCAnaGFuZGxlYmFycycpLnJlcGxhY2UoL1tcXFxcXiQqKz8uKCk6PSF8e31cXC1cXFtcXF1dL2csIGZ1bmN0aW9uKGFyZykgeyByZXR1cm4gJ1xcXFwnICsgYXJnOyB9KTtcbiAgZXh0ZW5zaW9uID0gbmV3IFJlZ0V4cCgnXFxcXC4nICsgZXh0ZW5zaW9uICsgJyQnKTtcblxuICBsZXQgcmV0ID0gW10sXG4gICAgICBxdWV1ZSA9IChvcHRzLmZpbGVzIHx8IFtdKS5tYXAoKHRlbXBsYXRlKSA9PiAoe3RlbXBsYXRlLCByb290OiBvcHRzLnJvb3R9KSk7XG4gIEFzeW5jLndoaWxzdCgoKSA9PiBxdWV1ZS5sZW5ndGgsIGZ1bmN0aW9uKGNhbGxiYWNrKSB7XG4gICAgbGV0IHt0ZW1wbGF0ZTogcGF0aCwgcm9vdH0gPSBxdWV1ZS5zaGlmdCgpO1xuXG4gICAgZnMuc3RhdChwYXRoLCBmdW5jdGlvbihlcnIsIHN0YXQpIHtcbiAgICAgIGlmIChlcnIpIHtcbiAgICAgICAgcmV0dXJuIGNhbGxiYWNrKG5ldyBIYW5kbGViYXJzLkV4Y2VwdGlvbihgVW5hYmxlIHRvIG9wZW4gdGVtcGxhdGUgZmlsZSBcIiR7cGF0aH1cImApKTtcbiAgICAgIH1cblxuICAgICAgaWYgKHN0YXQuaXNEaXJlY3RvcnkoKSkge1xuICAgICAgICBvcHRzLmhhc0RpcmVjdG9yeSA9IHRydWU7XG5cbiAgICAgICAgZnMucmVhZGRpcihwYXRoLCBmdW5jdGlvbihlcnIsIGNoaWxkcmVuKSB7XG4gICAgICAgICAgLyogaXN0YW5idWwgaWdub3JlIG5leHQgOiBSYWNlIGNvbmRpdGlvbiB0aGF0IGJlaW5nIHRvbyBsYXp5IHRvIHRlc3QgKi9cbiAgICAgICAgICBpZiAoZXJyKSB7XG4gICAgICAgICAgICByZXR1cm4gY2FsbGJhY2soZXJyKTtcbiAgICAgICAgICB9XG4gICAgICAgICAgY2hpbGRyZW4uZm9yRWFjaChmdW5jdGlvbihmaWxlKSB7XG4gICAgICAgICAgICBsZXQgY2hpbGRQYXRoID0gcGF0aCArICcvJyArIGZpbGU7XG5cbiAgICAgICAgICAgIGlmIChleHRlbnNpb24udGVzdChjaGlsZFBhdGgpIHx8IGZzLnN0YXRTeW5jKGNoaWxkUGF0aCkuaXNEaXJlY3RvcnkoKSkge1xuICAgICAgICAgICAgICBxdWV1ZS5wdXNoKHt0ZW1wbGF0ZTogY2hpbGRQYXRoLCByb290OiByb290IHx8IHBhdGh9KTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KTtcblxuICAgICAgICAgIGNhbGxiYWNrKCk7XG4gICAgICAgIH0pO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgZnMucmVhZEZpbGUocGF0aCwgJ3V0ZjgnLCBmdW5jdGlvbihlcnIsIGRhdGEpIHtcbiAgICAgICAgICAvKiBpc3RhbmJ1bCBpZ25vcmUgbmV4dCA6IFJhY2UgY29uZGl0aW9uIHRoYXQgYmVpbmcgdG9vIGxhenkgdG8gdGVzdCAqL1xuICAgICAgICAgIGlmIChlcnIpIHtcbiAgICAgICAgICAgIHJldHVybiBjYWxsYmFjayhlcnIpO1xuICAgICAgICAgIH1cblxuICAgICAgICAgIGlmIChvcHRzLmJvbSAmJiBkYXRhLmluZGV4T2YoJ1xcdUZFRkYnKSA9PT0gMCkge1xuICAgICAgICAgICAgZGF0YSA9IGRhdGEuc3Vic3RyaW5nKDEpO1xuICAgICAgICAgIH1cblxuICAgICAgICAgIC8vIENsZWFuIHRoZSB0ZW1wbGF0ZSBuYW1lXG4gICAgICAgICAgbGV0IG5hbWUgPSBwYXRoO1xuICAgICAgICAgIGlmICghcm9vdCkge1xuICAgICAgICAgICAgbmFtZSA9IGJhc2VuYW1lKG5hbWUpO1xuICAgICAgICAgIH0gZWxzZSBpZiAobmFtZS5pbmRleE9mKHJvb3QpID09PSAwKSB7XG4gICAgICAgICAgICBuYW1lID0gbmFtZS5zdWJzdHJpbmcocm9vdC5sZW5ndGggKyAxKTtcbiAgICAgICAgICB9XG4gICAgICAgICAgbmFtZSA9IG5hbWUucmVwbGFjZShleHRlbnNpb24sICcnKTtcblxuICAgICAgICAgIHJldC5wdXNoKHtcbiAgICAgICAgICAgIHBhdGg6IHBhdGgsXG4gICAgICAgICAgICBuYW1lOiBuYW1lLFxuICAgICAgICAgICAgc291cmNlOiBkYXRhXG4gICAgICAgICAgfSk7XG5cbiAgICAgICAgICBjYWxsYmFjaygpO1xuICAgICAgICB9KTtcbiAgICAgIH1cbiAgICB9KTtcbiAgfSxcbiAgZnVuY3Rpb24oZXJyKSB7XG4gICAgaWYgKGVycikge1xuICAgICAgY2FsbGJhY2soZXJyKTtcbiAgICB9IGVsc2Uge1xuICAgICAgY2FsbGJhY2sodW5kZWZpbmVkLCByZXQpO1xuICAgIH1cbiAgfSk7XG59XG5cbm1vZHVsZS5leHBvcnRzLmNsaSA9IGZ1bmN0aW9uKG9wdHMpIHtcbiAgaWYgKG9wdHMudmVyc2lvbikge1xuICAgIGNvbnNvbGUubG9nKEhhbmRsZWJhcnMuVkVSU0lPTik7XG4gICAgcmV0dXJuO1xuICB9XG5cbiAgaWYgKCFvcHRzLnRlbXBsYXRlcy5sZW5ndGggJiYgIW9wdHMuaGFzRGlyZWN0b3J5KSB7XG4gICAgdGhyb3cgbmV3IEhhbmRsZWJhcnMuRXhjZXB0aW9uKCdNdXN0IGRlZmluZSBhdCBsZWFzdCBvbmUgdGVtcGxhdGUgb3IgZGlyZWN0b3J5LicpO1xuICB9XG5cbiAgaWYgKG9wdHMuc2ltcGxlICYmIG9wdHMubWluKSB7XG4gICAgdGhyb3cgbmV3IEhhbmRsZWJhcnMuRXhjZXB0aW9uKCdVbmFibGUgdG8gbWluaW1pemUgc2ltcGxlIG91dHB1dCcpO1xuICB9XG5cbiAgY29uc3QgbXVsdGlwbGUgPSBvcHRzLnRlbXBsYXRlcy5sZW5ndGggIT09IDEgfHwgb3B0cy5oYXNEaXJlY3Rvcnk7XG4gIGlmIChvcHRzLnNpbXBsZSAmJiBtdWx0aXBsZSkge1xuICAgIHRocm93IG5ldyBIYW5kbGViYXJzLkV4Y2VwdGlvbignVW5hYmxlIHRvIG91dHB1dCBtdWx0aXBsZSB0ZW1wbGF0ZXMgaW4gc2ltcGxlIG1vZGUnKTtcbiAgfVxuXG4gIC8vIEZvcmNlIHNpbXBsZSBtb2RlIGlmIHdlIGhhdmUgb25seSBvbmUgdGVtcGxhdGUgYW5kIGl0J3MgdW5uYW1lZC5cbiAgaWYgKCFvcHRzLmFtZCAmJiAhb3B0cy5jb21tb25qcyAmJiBvcHRzLnRlbXBsYXRlcy5sZW5ndGggPT09IDFcbiAgICAgICYmICFvcHRzLnRlbXBsYXRlc1swXS5uYW1lKSB7XG4gICAgb3B0cy5zaW1wbGUgPSB0cnVlO1xuICB9XG5cbiAgLy8gQ29udmVydCB0aGUga25vd24gbGlzdCBpbnRvIGEgaGFzaFxuICBsZXQga25vd24gPSB7fTtcbiAgaWYgKG9wdHMua25vd24gJiYgIUFycmF5LmlzQXJyYXkob3B0cy5rbm93bikpIHtcbiAgICBvcHRzLmtub3duID0gW29wdHMua25vd25dO1xuICB9XG4gIGlmIChvcHRzLmtub3duKSB7XG4gICAgZm9yIChsZXQgaSA9IDAsIGxlbiA9IG9wdHMua25vd24ubGVuZ3RoOyBpIDwgbGVuOyBpKyspIHtcbiAgICAgIGtub3duW29wdHMua25vd25baV1dID0gdHJ1ZTtcbiAgICB9XG4gIH1cblxuICBjb25zdCBvYmplY3ROYW1lID0gb3B0cy5wYXJ0aWFsID8gJ0hhbmRsZWJhcnMucGFydGlhbHMnIDogJ3RlbXBsYXRlcyc7XG5cbiAgbGV0IG91dHB1dCA9IG5ldyBTb3VyY2VOb2RlKCk7XG4gIGlmICghb3B0cy5zaW1wbGUpIHtcbiAgICBpZiAob3B0cy5hbWQpIHtcbiAgICAgIG91dHB1dC5hZGQoJ2RlZmluZShbXFwnJyArIG9wdHMuaGFuZGxlYmFyUGF0aCArICdoYW5kbGViYXJzLnJ1bnRpbWVcXCddLCBmdW5jdGlvbihIYW5kbGViYXJzKSB7XFxuICBIYW5kbGViYXJzID0gSGFuZGxlYmFyc1tcImRlZmF1bHRcIl07Jyk7XG4gICAgfSBlbHNlIGlmIChvcHRzLmNvbW1vbmpzKSB7XG4gICAgICBvdXRwdXQuYWRkKCd2YXIgSGFuZGxlYmFycyA9IHJlcXVpcmUoXCInICsgb3B0cy5jb21tb25qcyArICdcIik7Jyk7XG4gICAgfSBlbHNlIHtcbiAgICAgIG91dHB1dC5hZGQoJyhmdW5jdGlvbigpIHtcXG4nKTtcbiAgICB9XG4gICAgb3V0cHV0LmFkZCgnICB2YXIgdGVtcGxhdGUgPSBIYW5kbGViYXJzLnRlbXBsYXRlLCB0ZW1wbGF0ZXMgPSAnKTtcbiAgICBpZiAob3B0cy5uYW1lc3BhY2UpIHtcbiAgICAgIG91dHB1dC5hZGQob3B0cy5uYW1lc3BhY2UpO1xuICAgICAgb3V0cHV0LmFkZCgnID0gJyk7XG4gICAgICBvdXRwdXQuYWRkKG9wdHMubmFtZXNwYWNlKTtcbiAgICAgIG91dHB1dC5hZGQoJyB8fCAnKTtcbiAgICB9XG4gICAgb3V0cHV0LmFkZCgne307XFxuJyk7XG4gIH1cblxuICBvcHRzLnRlbXBsYXRlcy5mb3JFYWNoKGZ1bmN0aW9uKHRlbXBsYXRlKSB7XG4gICAgbGV0IG9wdGlvbnMgPSB7XG4gICAgICBrbm93bkhlbHBlcnM6IGtub3duLFxuICAgICAga25vd25IZWxwZXJzT25seTogb3B0cy5vXG4gICAgfTtcblxuICAgIGlmIChvcHRzLm1hcCkge1xuICAgICAgb3B0aW9ucy5zcmNOYW1lID0gdGVtcGxhdGUucGF0aDtcbiAgICB9XG4gICAgaWYgKG9wdHMuZGF0YSkge1xuICAgICAgb3B0aW9ucy5kYXRhID0gdHJ1ZTtcbiAgICB9XG5cbiAgICBsZXQgcHJlY29tcGlsZWQgPSBIYW5kbGViYXJzLnByZWNvbXBpbGUodGVtcGxhdGUuc291cmNlLCBvcHRpb25zKTtcblxuICAgIC8vIElmIHdlIGFyZSBnZW5lcmF0aW5nIGEgc291cmNlIG1hcCwgd2UgaGF2ZSB0byByZWNvbnN0cnVjdCB0aGUgU291cmNlTm9kZSBvYmplY3RcbiAgICBpZiAob3B0cy5tYXApIHtcbiAgICAgIGxldCBjb25zdW1lciA9IG5ldyBTb3VyY2VNYXBDb25zdW1lcihwcmVjb21waWxlZC5tYXApO1xuICAgICAgcHJlY29tcGlsZWQgPSBTb3VyY2VOb2RlLmZyb21TdHJpbmdXaXRoU291cmNlTWFwKHByZWNvbXBpbGVkLmNvZGUsIGNvbnN1bWVyKTtcbiAgICB9XG5cbiAgICBpZiAob3B0cy5zaW1wbGUpIHtcbiAgICAgIG91dHB1dC5hZGQoW3ByZWNvbXBpbGVkLCAnXFxuJ10pO1xuICAgIH0gZWxzZSB7XG4gICAgICBpZiAoIXRlbXBsYXRlLm5hbWUpIHtcbiAgICAgICAgdGhyb3cgbmV3IEhhbmRsZWJhcnMuRXhjZXB0aW9uKCdOYW1lIG1pc3NpbmcgZm9yIHRlbXBsYXRlJyk7XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRzLmFtZCAmJiAhbXVsdGlwbGUpIHtcbiAgICAgICAgb3V0cHV0LmFkZCgncmV0dXJuICcpO1xuICAgICAgfVxuICAgICAgb3V0cHV0LmFkZChbb2JqZWN0TmFtZSwgJ1tcXCcnLCB0ZW1wbGF0ZS5uYW1lLCAnXFwnXSA9IHRlbXBsYXRlKCcsIHByZWNvbXBpbGVkLCAnKTtcXG4nXSk7XG4gICAgfVxuICB9KTtcblxuICAvLyBPdXRwdXQgdGhlIGNvbnRlbnRcbiAgaWYgKCFvcHRzLnNpbXBsZSkge1xuICAgIGlmIChvcHRzLmFtZCkge1xuICAgICAgaWYgKG11bHRpcGxlKSB7XG4gICAgICAgIG91dHB1dC5hZGQoWydyZXR1cm4gJywgb2JqZWN0TmFtZSwgJztcXG4nXSk7XG4gICAgICB9XG4gICAgICBvdXRwdXQuYWRkKCd9KTsnKTtcbiAgICB9IGVsc2UgaWYgKCFvcHRzLmNvbW1vbmpzKSB7XG4gICAgICBvdXRwdXQuYWRkKCd9KSgpOycpO1xuICAgIH1cbiAgfVxuXG5cbiAgaWYgKG9wdHMubWFwKSB7XG4gICAgb3V0cHV0LmFkZCgnXFxuLy8jIHNvdXJjZU1hcHBpbmdVUkw9JyArIG9wdHMubWFwICsgJ1xcbicpO1xuICB9XG5cbiAgb3V0cHV0ID0gb3V0cHV0LnRvU3RyaW5nV2l0aFNvdXJjZU1hcCgpO1xuICBvdXRwdXQubWFwID0gb3V0cHV0Lm1hcCArICcnO1xuXG4gIGlmIChvcHRzLm1pbikge1xuICAgIG91dHB1dCA9IHVnbGlmeS5taW5pZnkob3V0cHV0LmNvZGUsIHtcbiAgICAgIGZyb21TdHJpbmc6IHRydWUsXG5cbiAgICAgIG91dFNvdXJjZU1hcDogb3B0cy5tYXAsXG4gICAgICBpblNvdXJjZU1hcDogSlNPTi5wYXJzZShvdXRwdXQubWFwKVxuICAgIH0pO1xuICB9XG5cbiAgaWYgKG9wdHMubWFwKSB7XG4gICAgZnMud3JpdGVGaWxlU3luYyhvcHRzLm1hcCwgb3V0cHV0Lm1hcCwgJ3V0ZjgnKTtcbiAgfVxuICBvdXRwdXQgPSBvdXRwdXQuY29kZTtcblxuICBpZiAob3B0cy5vdXRwdXQpIHtcbiAgICBmcy53cml0ZUZpbGVTeW5jKG9wdHMub3V0cHV0LCBvdXRwdXQsICd1dGY4Jyk7XG4gIH0gZWxzZSB7XG4gICAgY29uc29sZS5sb2cob3V0cHV0KTtcbiAgfVxufTtcblxuZnVuY3Rpb24gYXJyYXlDYXN0KHZhbHVlKSB7XG4gIHZhbHVlID0gdmFsdWUgIT0gbnVsbCA/IHZhbHVlIDogW107XG4gIGlmICghQXJyYXkuaXNBcnJheSh2YWx1ZSkpIHtcbiAgICB2YWx1ZSA9IFt2YWx1ZV07XG4gIH1cbiAgcmV0dXJuIHZhbHVlO1xufVxuIl19
