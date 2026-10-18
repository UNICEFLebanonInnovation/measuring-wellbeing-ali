import 'package:flutter/material.dart';

/// Inter-Agency Coordination Lebanon palette (Pantone 300) used by the web platform.
class BrandColors {
  const BrandColors._();

  static const Color blue = Color(0xFF1B75BC);
  static const Color blueDark = Color(0xFF104A79);
  static const Color blueLight = Color(0xFFE8F1FA);
  static const Color green = Color(0xFF15803D);
  static const Color amber = Color(0xFFB45309);
  static const Color red = Color(0xFFB91C1C);
  static const Color slate = Color(0xFF334155);
}

ThemeData buildTheme() {
  final scheme = ColorScheme.fromSeed(seedColor: BrandColors.blue, primary: BrandColors.blue, brightness: Brightness.light);
  return ThemeData(
    useMaterial3: true,
    colorScheme: scheme,
    scaffoldBackgroundColor: const Color(0xFFF8FAFC),
    appBarTheme: const AppBarTheme(
      backgroundColor: Colors.white,
      foregroundColor: BrandColors.blueDark,
      elevation: 0,
      scrolledUnderElevation: 1,
      centerTitle: false,
    ),
    inputDecorationTheme: const InputDecorationTheme(border: OutlineInputBorder(), isDense: true, filled: true, fillColor: Colors.white),
    cardTheme: const CardThemeData(
      elevation: 0,
      color: Colors.white,
      margin: EdgeInsets.symmetric(horizontal: 12, vertical: 6),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.all(Radius.circular(10)),
        side: BorderSide(color: Color(0xFFE2E8F0)),
      ),
    ),
    filledButtonTheme: FilledButtonThemeData(
      style: FilledButton.styleFrom(
        minimumSize: const Size(48, 48),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      ),
    ),
    outlinedButtonTheme: OutlinedButtonThemeData(
      style: OutlinedButton.styleFrom(
        minimumSize: const Size(48, 48),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
      ),
    ),
    chipTheme: const ChipThemeData(
      shape: StadiumBorder(side: BorderSide(color: Color(0xFFE2E8F0))),
    ),
  );
}
