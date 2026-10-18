# Keep the SQLCipher JNI bridge and Flutter plugin registrants.
-keep class net.sqlcipher.** { *; }
-keep class io.flutter.plugins.** { *; }
-dontwarn net.sqlcipher.**
