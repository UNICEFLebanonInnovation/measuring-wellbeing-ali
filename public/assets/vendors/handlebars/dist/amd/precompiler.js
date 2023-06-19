define(['exports', 'async', 'fs', './handlebars', 'path', 'source-map', 'uglify-js'], function (exports, _async, _fs, _handlebars, _path, _sourceMap, _uglifyJs) {
  /* eslint-disable no-console */
  'use strict';

  // istanbul ignore next

  function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

  var _Async = _interopRequireDefault(_async);

  var _fs2 = _interopRequireDefault(_fs);

  var _uglify = _interopRequireDefault(_uglifyJs);

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
      return callback(new _handlebars.Exception('Number of names did not match the number of string inputs'));
    }

    _Async['default'].map(strings, function (string, callback) {
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
    _Async['default'].whilst(function () {
      return queue.length;
    }, function (callback) {
      var _queue$shift = queue.shift();

      var path = _queue$shift.template;
      var root = _queue$shift.root;

      _fs2['default'].stat(path, function (err, stat) {
        if (err) {
          return callback(new _handlebars.Exception('Unable to open template file "' + path + '"'));
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
      console.log(_handlebars.VERSION);
      return;
    }

    if (!opts.templates.length && !opts.hasDirectory) {
      throw new _handlebars.Exception('Must define at least one template or directory.');
    }

    if (opts.simple && opts.min) {
      throw new _handlebars.Exception('Unable to minimize simple output');
    }

    var multiple = opts.templates.length !== 1 || opts.hasDirectory;
    if (opts.simple && multiple) {
      throw new _handlebars.Exception('Unable to output multiple templates in simple mode');
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

      var precompiled = _handlebars.precompile(template.source, options);

      // If we are generating a source map, we have to reconstruct the SourceNode object
      if (opts.map) {
        var consumer = new _sourceMap.SourceMapConsumer(precompiled.map);
        precompiled = _sourceMap.SourceNode.fromStringWithSourceMap(precompiled.code, consumer);
      }

      if (opts.simple) {
        output.add([precompiled, '\n']);
      } else {
        if (!template.name) {
          throw new _handlebars.Exception('Name missing for template');
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
      output = _uglify['default'].minify(output.code, {
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
});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uL2xpYi9wcmVjb21waWxlci5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7OztBQVFBLFFBQU0sQ0FBQyxPQUFPLENBQUMsYUFBYSxHQUFHLFVBQVMsSUFBSSxFQUFFLFFBQVEsRUFBRTtBQUN0RCxlQUFXLENBQUMsSUFBSSxFQUFFLFVBQVMsR0FBRyxFQUFFLE9BQU8sRUFBRTtBQUN2QyxVQUFJLEdBQUcsRUFBRTtBQUNQLGdCQUFRLENBQUMsR0FBRyxDQUFDLENBQUM7T0FDZixNQUFNO0FBQ0wsaUJBQVMsQ0FBQyxJQUFJLEVBQUUsVUFBUyxHQUFHLEVBQUUsS0FBSyxFQUFFO0FBQ25DLGNBQUksR0FBRyxFQUFFO0FBQ1Asb0JBQVEsQ0FBQyxHQUFHLENBQUMsQ0FBQztXQUNmLE1BQU07QUFDTCxnQkFBSSxDQUFDLFNBQVMsR0FBRyxPQUFPLENBQUMsTUFBTSxDQUFDLEtBQUssQ0FBQyxDQUFDO0FBQ3ZDLG9CQUFRLENBQUMsU0FBUyxFQUFFLElBQUksQ0FBQyxDQUFDO1dBQzNCO1NBQ0YsQ0FBQyxDQUFDO09BQ0o7S0FDRixDQUFDLENBQUM7R0FDSixDQUFDOztBQUVGLFdBQVMsV0FBVyxDQUFDLElBQUksRUFBRSxRQUFRLEVBQUU7QUFDbkMsUUFBSSxPQUFPLEdBQUcsU0FBUyxDQUFDLElBQUksQ0FBQyxNQUFNLENBQUM7UUFDaEMsS0FBSyxHQUFHLFNBQVMsQ0FBQyxJQUFJLENBQUMsSUFBSSxDQUFDLENBQUM7O0FBRWpDLFFBQUksS0FBSyxDQUFDLE1BQU0sS0FBSyxPQUFPLENBQUMsTUFBTSxJQUM1QixPQUFPLENBQUMsTUFBTSxHQUFHLENBQUMsRUFBRTtBQUN6QixhQUFPLFFBQVEsQ0FBQyxJQUFJLFlBQVcsU0FBUyxDQUFDLDJEQUEyRCxDQUFDLENBQUMsQ0FBQztLQUN4Rzs7QUFFRCxzQkFBTSxHQUFHLENBQUMsT0FBTyxFQUFFLFVBQVMsTUFBTSxFQUFFLFFBQVEsRUFBRTtBQUMxQyxVQUFJLE1BQU0sS0FB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LEdBQUcsQ0FBQztPQUNwQyxDQUFDLENBQUM7S0FDSjs7QUFFRCxRQUFJLElBQUksQ0FBQyxHQUFHLEVBQUU7QUFDWixzQkFBRyxhQUFhLENBQUMsSUFBSSxDQUFDLEdBQUcsRUFBRSxNQUFNLENBQUMsR0FBRyxFQUFFLE1BQU0sQ0FBQyxDQUFDO0tBQ2hEO0FBQ0QsVUFBTSxHQUFHLE1BQU0sQ0FBQyxJQUFJLENBQUM7O0FBRXJCLFFBQUksSUFBSSxDQUFDLE1BQU0sRUFBRTtBQUNmLHNCQUFHLGFBQWEsQ0FBQyxJQUFJLENBQUMsTUFBTSxFQUFFLE1BQU0sRUFBRSxNQUFNLENBQUMsQ0FBQztLQUMvQyxNQUFNO0FBQ0wsYUFBTyxDQUFDLEdBQUcsQ0FBQyxNQUFNLENBQUMsQ0FBQztLQUNyQjtHQUNGLENBQUM7O0FBRUYsV0FBUyxTQUFTLENBQUMsS0FBSyxFQUFFO0FBQ3hCLFNBQUssR0FBRyxLQUFLLElBQUksSUFBSSxHQUFHLEtBQUssR0FBRyxFQUFFLENBQUM7QUFDbkMsUUFBSSxDQUFDLEtBQUssQ0FBQyxPQUFPLENBQUMsS0FBSyxDQUFDLEVBQUU7QUFDekIsV0FBSyxHQUFHLENBQUMsS0FBSyxDQUFDLENBQUM7S0FDakI7QUFDRCxXQUFPLEtBQUssQ0FBQztHQUNkIiwiZmlsZSI6InByZWNvbXBpbGVyLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLyogZXNsaW50LWRpc2FibGUgbm8tY29uc29sZSAqL1xuaW1wb3J0IEFzeW5jIGZyb20gJ2FzeW5jJztcbmltcG9ydCBmcyBmcm9tICdmcyc7XG5pbXBvcnQgKiBhcyBIYW5kbGViYXJzIGZyb20gJy4vaGFuZGxlYmFycyc7XG5pbXBvcnQge2Jhc2VuYW1lfSBmcm9tICdwYXRoJztcbmltcG9ydCB7U291cmNlTWFwQ29uc3VtZXIsIFNvdXJjZU5vZGV9IGZyb20gJ3NvdXJjZS1tYXAnO1xuaW1wb3J0IHVnbGlmeSBmcm9tICd1Z2xpZnktanMnO1xuXG5tb2R1bGUuZXhwb3J0cy5sb2FkVGVtcGxhdGVzID0gZnVuY3Rpb24ob3B0cywgY2FsbGJhY2spIHtcbiAgbG9hZFN0cmluZ3Mob3B0cywgZnVuY3Rpb24oZXJyLCBzdHJpbmdzKSB7XG4gICAgaWYgKGVycikge1xuICAgICAgY2FsbGJhY2soZXJyKTtcbiAgICB9IGVsc2Uge1xuICAgICAgbG9hZEZpbGVzKG9wdHMsIGZ1bmN0aW9uKGVyciwgZmlsZXMpIHtcbiAgICAgICAgaWYgKGVycikge1xuICAgICAgICAgIGNhbGxiYWNrKGVycik7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgb3B0cy50ZW1wbGF0ZXMgPSBzdHJpbmdzLmNvbmNhdChmaWxlcyk7XG4gICAgICAgICAgY2FsbGJhY2sodW5kZWZpbmVkLCBvcHRzKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG4gICAgfVxuICB9KTtcbn07XG5cbmZ1bmN0aW9uIGxvYWRTdHJpbmdzKG9wdHMsIGNhbGxiYWNrKSB7XG4gIGxldCBzdHJpbmdzID0gYXJyYXlDYXN0KG9wdHMuc3RyaW5nKSxcbiAgICAgIG5hbWVzID0gYXJyYXlDYXN0KG9wdHMubmFtZSk7XG5cbiAgaWYgKG5hbWVzLmxlbmd0aCAhPT0gc3RyaW5ncy5sZW5ndGhcbiAgICAgICYmIHN0cmluZ3MubGVuZ3RoID4gMSkge1xuICAgIHJldHVybiBjYWxsYmFjayhuZXcgSGFuZGxlYmFycy5FeGNlcHRpb24oJ051bWJlciBvZiBuYW1lcyBkaWQgbm90IG1hdGNoIHRoZSBudW1iZXIgb2Ygc3RyaW5nIGlucHV0cycpKTtcbiAgfVxuXG4gIEFzeW5jLm1hcChzdHJpbmdzLCBmdW5jdGlvbihzdHJpbmcsIGNhbGxiYWNrKSB7XG4gICAgICBpZiAoc3RyaW5nICE9PSAnLScpIHtcbiAgICAgICAgY2FsbGJhY2sodW5kZWZpbmVkLCBzdHJpbmcpO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgLy8gTG9hZCBmcm9tIHN0ZGluXG4gICAgICAgIGxldCBidWZmZXIgPSAnJztcbiAgICAgICAgcHJvY2Vzcy5zdGRpbi5zZXRFbmNvZGluZygndXRmOCcpO1xuXG4gICAgICAgIHByb2Nlc3Muc3RkaW4ub24oJ2RhdGEnLCBmdW5jdGlvbihjaHVuaykge1xuICAgICAgICAgIGJ1ZmZlciArPSBjaHVuaztcbiAgICAgICAgfSk7XG4gICAgICAgIHByb2Nlc3Muc3RkaW4ub24oJ2VuZCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgIGNhbGxiYWNrKHVuZGVmaW5lZCwgYnVmZmVyKTtcbiAgICAgICAgfSk7XG4gICAgICB9XG4gICAgfSxcbiAgICBmdW5jdGlvbihlcnIsIHN0cmluZ3MpIHtcbiAgICAgIHN0cmluZ3MgPSBzdHJpbmdzLm1hcCgoc3RyaW5nLCBpbmRleCkgPT4gKHtcbiAgICAgICAgbmFtZTogbmFtZXNbaW5kZXhdLFxuICAgICAgICBwYXRoOiBuYW1lc1tpbmRleF0sXG4gICAgICAgIHNvdXJjZTogc3RyaW5nXG4gICAgICB9KSk7XG4gICAgICBjYWxsYmFjayhlcnIsIHN0cmluZ3MpO1xuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBsb2FkRmlsZXMob3B0cywgY2FsbGJhY2spIHtcbiAgLy8gQnVpbGQgZmlsZSBleHRlbnNpb24gcGF0dGVyblxuICBsZXQgZXh0ZW5zaW9uID0gKG9wdHMuZXh0ZW5zaW9uIHx8ICdoYW5kbGViYXJzJykucmVwbGFjZSgvW1xcXFxeJCorPy4oKTo9IXx7fVxcLVxcW1xcXV0vZywgZnVuY3Rpb24oYXJnKSB7IHJldHVybiAnXFxcXCcgKyBhcmc7IH0pO1xuICBleHRlbnNpb24gPSBuZXcgUmVnRXhwKCdcXFxcLicgKyBleHRlbnNpb24gKyAnJCcpO1xuXG4gIGxldCByZXQgPSBbXSxcbiAgICAgIHF1ZXVlID0gKG9wdHMuZmlsZXMgfHwgW10pLm1hcCgodGVtcGxhdGUpID0+ICh7dGVtcGxhdGUsIHJvb3Q6IG9wdHMucm9vdH0pKTtcbiAgQXN5bmMud2hpbHN0KCgpID0+IHF1ZXVlLmxlbmd0aCwgZnVuY3Rpb24oY2FsbGJhY2spIHtcbiAgICBsZXQge3RlbXBsYXRlOiBwYXRoLCByb290fSA9IHF1ZXVlLnNoaWZ0KCk7XG5cbiAgICBmcy5zdGF0KHBhdGgsIGZ1bmN0aW9uKGVyciwgc3RhdCkge1xuICAgICAgaWYgKGVycikge1xuICAgICAgICByZXR1cm4gY2FsbGJhY2sobmV3IEhhbmRsZWJhcnMuRXhjZXB0aW9uKGBVbmFibGUgdG8gb3BlbiB0ZW1wbGF0ZSBmaWxlIFwiJHtwYXRofVwiYCkpO1xuICAgICAgfVxuXG4gICAgICBpZiAoc3RhdC5pc0RpcmVjdG9yeSgpKSB7XG4gICAgICAgIG9wdHMuaGFzRGlyZWN0b3J5ID0gdHJ1ZTtcblxuICAgICAgICBmcy5yZWFkZGlyKHBhdGgsIGZ1bmN0aW9uKGVyciwgY2hpbGRyZW4pIHtcbiAgICAgICAgICAvKiBpc3RhbmJ1bCBpZ25vcmUgbmV4dCA6IFJhY2UgY29uZGl0aW9uIHRoYXQgYmVpbmcgdG9vIGxhenkgdG8gdGVzdCAqL1xuICAgICAgICAgIGlmIChlcnIpIHtcbiAgICAgICAgICAgIHJldHVybiBjYWxsYmFjayhlcnIpO1xuICAgICAgICAgIH1cbiAgICAgICAgICBjaGlsZHJlbi5mb3JFYWNoKGZ1bmN0aW9uKGZpbGUpIHtcbiAgICAgICAgICAgIGxldCBjaGlsZFBhdGggPSBwYXRoICsgJy8nICsgZmlsZTtcblxuICAgICAgICAgICAgaWYgKGV4dGVuc2lvbi50ZXN0KGNoaWxkUGF0aCkgfHwgZnMuc3RhdFN5bmMoY2hpbGRQYXRoKS5pc0RpcmVjdG9yeSgpKSB7XG4gICAgICAgICAgICAgIHF1ZXVlLnB1c2goe3RlbXBsYXRlOiBjaGlsZFBhdGgsIHJvb3Q6IHJvb3QgfHwgcGF0aH0pO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgY2FsbGJhY2soKTtcbiAgICAgICAgfSk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBmcy5yZWFkRmlsZShwYXRoLCAndXRmOCcsIGZ1bmN0aW9uKGVyciwgZGF0YSkge1xuICAgICAgICAgIC8qIGlzdGFuYnVsIGlnbm9yZSBuZXh0IDogUmFjZSBjb25kaXRpb24gdGhhdCBiZWluZyB0b28gbGF6eSB0byB0ZXN0ICovXG4gICAgICAgICAgaWYgKGVycikge1xuICAgICAgICAgICAgcmV0dXJuIGNhbGxiYWNrKGVycik7XG4gICAgICAgICAgfVxuXG4gICAgICAgICAgaWYgKG9wdHMuYm9tICYmIGRhdGEuaW5kZXhPZignXFx1RkVGRicpID09PSAwKSB7XG4gICAgICAgICAgICBkYXRhID0gZGF0YS5zdWJzdHJpbmcoMSk7XG4gICAgICAgICAgfVxuXG4gICAgICAgICAgLy8gQ2xlYW4gdGhlIHRlbXBsYXRlIG5hbWVcbiAgICAgICAgICBsZXQgbmFtZSA9IHBhdGg7XG4gICAgICAgICAgaWYgKCFyb290KSB7XG4gICAgICAgICAgICBuYW1lID0gYmFzZW5hbWUobmFtZSk7XG4gICAgICAgICAgfSBlbHNlIGlmIChuYW1lLmluZGV4T2Yocm9vdCkgPT09IDApIHtcbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLnN1YnN0cmluZyhyb290Lmxlbmd0aCArIDEpO1xuICAgICAgICAgIH1cbiAgICAgICAgICBuYW1lID0gbmFtZS5yZXBsYWNlKGV4dGVuc2lvbiwgJycpO1xuXG4gICAgICAgICAgcmV0LnB1c2goe1xuICAgICAgICAgICAgcGF0aDogcGF0aCxcbiAgICAgICAgICAgIG5hbWU6IG5hbWUsXG4gICAgICAgICAgICBzb3VyY2U6IGRhdGFcbiAgICAgICAgICB9KTtcblxuICAgICAgICAgIGNhbGxiYWNrKCk7XG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0pO1xuICB9LFxuICBmdW5jdGlvbihlcnIpIHtcbiAgICBpZiAoZXJyKSB7XG4gICAgICBjYWxsYmFjayhlcnIpO1xuICAgIH0gZWxzZSB7XG4gICAgICBjYWxsYmFjayh1bmRlZmluZWQsIHJldCk7XG4gICAgfVxuICB9KTtcbn1cblxubW9kdWxlLmV4cG9ydHMuY2xpID0gZnVuY3Rpb24ob3B0cykge1xuICBpZiAob3B0cy52ZXJzaW9uKSB7XG4gICAgY29uc29sZS5sb2coSGFuZGxlYmFycy5WRVJTSU9OKTtcbiAgICByZXR1cm47XG4gIH1cblxuICBpZiAoIW9wdHMudGVtcGxhdGVzLmxlbmd0aCAmJiAhb3B0cy5oYXNEaXJlY3RvcnkpIHtcbiAgICB0aHJvdyBuZXcgSGFuZGxlYmFycy5FeGNlcHRpb24oJ011c3QgZGVmaW5lIGF0IGxlYXN0IG9uZSB0ZW1wbGF0ZSBvciBkaXJlY3RvcnkuJyk7XG4gIH1cblxuICBpZiAob3B0cy5zaW1wbGUgJiYgb3B0cy5taW4pIHtcbiAgICB0aHJvdyBuZXcgSGFuZGxlYmFycy5FeGNlcHRpb24oJ1VuYWJsZSB0byBtaW5pbWl6ZSBzaW1wbGUgb3V0cHV0Jyk7XG4gIH1cblxuICBjb25zdCBtdWx0aXBsZSA9IG9wdHMudGVtcGxhdGVzLmxlbmd0aCAhPT0gMSB8fCBvcHRzLmhhc0RpcmVjdG9yeTtcbiAgaWYgKG9wdHMuc2ltcGxlICYmIG11bHRpcGxlKSB7XG4gICAgdGhyb3cgbmV3IEhhbmRsZWJhcnMuRXhjZXB0aW9uKCdVbmFibGUgdG8gb3V0cHV0IG11bHRpcGxlIHRlbXBsYXRlcyBpbiBzaW1wbGUgbW9kZScpO1xuICB9XG5cbiAgLy8gRm9yY2Ugc2ltcGxlIG1vZGUgaWYgd2UgaGF2ZSBvbmx5IG9uZSB0ZW1wbGF0ZSBhbmQgaXQncyB1bm5hbWVkLlxuICBpZiAoIW9wdHMuYW1kICYmICFvcHRzLmNvbW1vbmpzICYmIG9wdHMudGVtcGxhdGVzLmxlbmd0aCA9PT0gMVxuICAgICAgJiYgIW9wdHMudGVtcGxhdGVzWzBdLm5hbWUpIHtcbiAgICBvcHRzLnNpbXBsZSA9IHRydWU7XG4gIH1cblxuICAvLyBDb252ZXJ0IHRoZSBrbm93biBsaXN0IGludG8gYSBoYXNoXG4gIGxldCBrbm93biA9IHt9O1xuICBpZiAob3B0cy5rbm93biAmJiAhQXJyYXkuaXNBcnJheShvcHRzLmtub3duKSkge1xuICAgIG9wdHMua25vd24gPSBbb3B0cy5rbm93bl07XG4gIH1cbiAgaWYgKG9wdHMua25vd24pIHtcbiAgICBmb3IgKGxldCBpID0gMCwgbGVuID0gb3B0cy5rbm93bi5sZW5ndGg7IGkgPCBsZW47IGkrKykge1xuICAgICAga25vd25bb3B0cy5rbm93bltpXV0gPSB0cnVlO1xuICAgIH1cbiAgfVxuXG4gIGNvbnN0IG9iamVjdE5hbWUgPSBvcHRzLnBhcnRpYWwgPyAnSGFuZGxlYmFycy5wYXJ0aWFscycgOiAndGVtcGxhdGVzJztcblxuICBsZXQgb3V0cHV0ID0gbmV3IFNvdXJjZU5vZGUoKTtcbiAgaWYgKCFvcHRzLnNpbXBsZSkge1xuICAgIGlmIChvcHRzLmFtZCkge1xuICAgICAgb3V0cHV0LmFkZCgnZGVmaW5lKFtcXCcnICsgb3B0cy5oYW5kbGViYXJQYXRoICsgJ2hhbmRsZWJhcnMucnVudGltZVxcJ10sIGZ1bmN0aW9uKEhhbmRsZWJhcnMpIHtcXG4gIEhhbmRsZWJhcnMgPSBIYW5kbGViYXJzW1wiZGVmYXVsdFwiXTsnKTtcbiAgICB9IGVsc2UgaWYgKG9wdHMuY29tbW9uanMpIHtcbiAgICAgIG91dHB1dC5hZGQoJ3ZhciBIYW5kbGViYXJzID0gcmVxdWlyZShcIicgKyBvcHRzLmNvbW1vbmpzICsgJ1wiKTsnKTtcbiAgICB9IGVsc2Uge1xuICAgICAgb3V0cHV0LmFkZCgnKGZ1bmN0aW9uKCkge1xcbicpO1xuICAgIH1cbiAgICBvdXRwdXQuYWRkKCcgIHZhciB0ZW1wbGF0ZSA9IEhhbmRsZWJhcnMudGVtcGxhdGUsIHRlbXBsYXRlcyA9ICcpO1xuICAgIGlmIChvcHRzLm5hbWVzcGFjZSkge1xuICAgICAgb3V0cHV0LmFkZChvcHRzLm5hbWVzcGFjZSk7XG4gICAgICBvdXRwdXQuYWRkKCcgPSAnKTtcbiAgICAgIG91dHB1dC5hZGQob3B0cy5uYW1lc3BhY2UpO1xuICAgICAgb3V0cHV0LmFkZCgnIHx8ICcpO1xuICAgIH1cbiAgICBvdXRwdXQuYWRkKCd7fTtcXG4nKTtcbiAgfVxuXG4gIG9wdHMudGVtcGxhdGVzLmZvckVhY2goZnVuY3Rpb24odGVtcGxhdGUpIHtcbiAgICBsZXQgb3B0aW9ucyA9IHtcbiAgICAgIGtub3duSGVscGVyczoga25vd24sXG4gICAgICBrbm93bkhlbHBlcnNPbmx5OiBvcHRzLm9cbiAgICB9O1xuXG4gICAgaWYgKG9wdHMubWFwKSB7XG4gICAgICBvcHRpb25zLnNyY05hbWUgPSB0ZW1wbGF0ZS5wYXRoO1xuICAgIH1cbiAgICBpZiAob3B0cy5kYXRhKSB7XG4gICAgICBvcHRpb25zLmRhdGEgPSB0cnVlO1xuICAgIH1cblxuICAgIGxldCBwcmVjb21waWxlZCA9IEhhbmRsZWJhcnMucHJlY29tcGlsZSh0ZW1wbGF0ZS5zb3VyY2UsIG9wdGlvbnMpO1xuXG4gICAgLy8gSWYgd2UgYXJlIGdlbmVyYXRpbmcgYSBzb3VyY2UgbWFwLCB3ZSBoYXZlIHRvIHJlY29uc3RydWN0IHRoZSBTb3VyY2VOb2RlIG9iamVjdFxuICAgIGlmIChvcHRzLm1hcCkge1xuICAgICAgbGV0IGNvbnN1bWVyID0gbmV3IFNvdXJjZU1hcENvbnN1bWVyKHByZWNvbXBpbGVkLm1hcCk7XG4gICAgICBwcmVjb21waWxlZCA9IFNvdXJjZU5vZGUuZnJvbVN0cmluZ1dpdGhTb3VyY2VNYXAocHJlY29tcGlsZWQuY29kZSwgY29uc3VtZXIpO1xuICAgIH1cblxuICAgIGlmIChvcHRzLnNpbXBsZSkge1xuICAgICAgb3V0cHV0LmFkZChbcHJlY29tcGlsZWQsICdcXG4nXSk7XG4gICAgfSBlbHNlIHtcbiAgICAgIGlmICghdGVtcGxhdGUubmFtZSkge1xuICAgICAgICB0aHJvdyBuZXcgSGFuZGxlYmFycy5FeGNlcHRpb24oJ05hbWUgbWlzc2luZyBmb3IgdGVtcGxhdGUnKTtcbiAgICAgIH1cblxuICAgICAgaWYgKG9wdHMuYW1kICYmICFtdWx0aXBsZSkge1xuICAgICAgICBvdXRwdXQuYWRkKCdyZXR1cm4gJyk7XG4gICAgICB9XG4gICAgICBvdXRwdXQuYWRkKFtvYmplY3ROYW1lLCAnW1xcJycsIHRlbXBsYXRlLm5hbWUsICdcXCddID0gdGVtcGxhdGUoJywgcHJlY29tcGlsZWQsICcpO1xcbiddKTtcbiAgICB9XG4gIH0pO1xuXG4gIC8vIE91dHB1dCB0aGUgY29udGVudFxuICBpZiAoIW9wdHMuc2ltcGxlKSB7XG4gICAgaWYgKG9wdHMuYW1kKSB7XG4gICAgICBpZiAobXVsdGlwbGUpIHtcbiAgICAgICAgb3V0cHV0LmFkZChbJ3JldHVybiAnLCBvYmplY3ROYW1lLCAnO1xcbiddKTtcbiAgICAgIH1cbiAgICAgIG91dHB1dC5hZGQoJ30pOycpO1xuICAgIH0gZWxzZSBpZiAoIW9wdHMuY29tbW9uanMpIHtcbiAgICAgIG91dHB1dC5hZGQoJ30pKCk7Jyk7XG4gICAgfVxuICB9XG5cblxuICBpZiAob3B0cy5tYXApIHtcbiAgICBvdXRwdXQuYWRkKCdcXG4vLyMgc291cmNlTWFwcGluZ1VSTD0nICsgb3B0cy5tYXAgKyAnXFxuJyk7XG4gIH1cblxuICBvdXRwdXQgPSBvdXRwdXQudG9TdHJpbmdXaXRoU291cmNlTWFwKCk7XG4gIG91dHB1dC5tYXAgPSBvdXRwdXQubWFwICsgJyc7XG5cbiAgaWYgKG9wdHMubWluKSB7XG4gICAgb3V0cHV0ID0gdWdsaWZ5Lm1pbmlmeShvdXRwdXQuY29kZSwge1xuICAgICAgZnJvbVN0cmluZzogdHJ1ZSxcblxuICAgICAgb3V0U291cmNlTWFwOiBvcHRzLm1hcCxcbiAgICAgIGluU291cmNlTWFwOiBKU09OLnBhcnNlKG91dHB1dC5tYXApXG4gICAgfSk7XG4gIH1cblxuICBpZiAob3B0cy5tYXApIHtcbiAgICBmcy53cml0ZUZpbGVTeW5jKG9wdHMubWFwLCBvdXRwdXQubWFwLCAndXRmOCcpO1xuICB9XG4gIG91dHB1dCA9IG91dHB1dC5jb2RlO1xuXG4gIGlmIChvcHRzLm91dHB1dCkge1xuICAgIGZzLndyaXRlRmlsZVN5bmMob3B0cy5vdXRwdXQsIG91dHB1dCwgJ3V0ZjgnKTtcbiAgfSBlbHNlIHtcbiAgICBjb25zb2xlLmxvZyhvdXRwdXQpO1xuICB9XG59O1xuXG5mdW5jdGlvbiBhcnJheUNhc3QodmFsdWUpIHtcbiAgdmFsdWUgPSB2YWx1ZSAhPSBudWxsID8gdmFsdWUgOiBbXTtcbiAgaWYgKCFBcnJheS5pc0FycmF5KHZhbHVlKSkge1xuICAgIHZhbHVlID0gW3ZhbHVlXTtcbiAgfVxuICByZXR1cm4gdmFsdWU7XG59XG4iXX0=
