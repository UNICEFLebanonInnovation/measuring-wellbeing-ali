import java.util.Properties

plugins {
    id("com.android.application")
    // The Flutter Gradle Plugin must be applied after the Android and Kotlin Gradle plugins.
    id("dev.flutter.flutter-gradle-plugin")
}

// Release signing: android/key.properties (never committed) or the
// MW_KEYSTORE_* environment variables set by the GitHub Actions workflow.
val keystoreProperties = Properties().apply {
    val file = rootProject.file("key.properties")
    if (file.exists()) file.inputStream().use { load(it) }
}
val keystorePath = keystoreProperties.getProperty("storeFile") ?: System.getenv("MW_KEYSTORE_PATH")
val keystorePassword = keystoreProperties.getProperty("storePassword") ?: System.getenv("MW_KEYSTORE_PASSWORD")
val keyAliasValue = keystoreProperties.getProperty("keyAlias") ?: System.getenv("MW_KEY_ALIAS")
val keyPasswordValue = keystoreProperties.getProperty("keyPassword") ?: System.getenv("MW_KEY_PASSWORD")
val hasReleaseKey = keystorePath != null && File(keystorePath).exists()

android {
    namespace = "org.measuringwellbeing.measuring_wellbeing"
    compileSdk = flutter.compileSdkVersion
    ndkVersion = flutter.ndkVersion

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_17
        targetCompatibility = JavaVersion.VERSION_17
    }

    defaultConfig {
        applicationId = "org.measuringwellbeing.measuring_wellbeing"
        // sqflite_sqlcipher and flutter_secure_storage need API 23+.
        minSdk = maxOf(23, flutter.minSdkVersion)
        targetSdk = flutter.targetSdkVersion
        // Uses the version code from pubspec.yaml. When using split APKs, 1000 * ABI_VERSION
        // is added automatically by Flutter. (https://developer.android.com/studio/build/configure-apk-splits#configure-APK-versions)
        // You can force using the value of versionCode by specifying the `-P force-version-code-ignoring-abi=true`
        // flag during build.
        versionCode = flutter.versionCode
        versionName = flutter.versionName
    }

    signingConfigs {
        if (hasReleaseKey) {
            create("release") {
                storeFile = File(keystorePath!!)
                storePassword = keystorePassword
                keyAlias = keyAliasValue
                keyPassword = keyPasswordValue
            }
        }
    }

    buildTypes {
        release {
            // Signed with the release keystore when one is configured, otherwise with
            // the debug key so `flutter build apk` still works on a developer machine.
            signingConfig = if (hasReleaseKey) signingConfigs.getByName("release") else signingConfigs.getByName("debug")
            // Code shrinking is off: the APK is side-loaded, size is not a concern,
            // and R8 must not be able to strip plugin code at runtime.
            isMinifyEnabled = false
            isShrinkResources = false
        }
    }
}

kotlin {
    compilerOptions {
        jvmTarget = org.jetbrains.kotlin.gradle.dsl.JvmTarget.JVM_17
    }
}

flutter {
    source = "../.."
}
