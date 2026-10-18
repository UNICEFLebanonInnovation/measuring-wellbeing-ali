import 'package:geolocator/geolocator.dart';

class CapturedPosition {
  const CapturedPosition({required this.latitude, required this.longitude, this.altitude, this.accuracy});
  final double latitude;
  final double longitude;
  final double? altitude;
  final double? accuracy;
}

class LocationException implements Exception {
  const LocationException(this.message);
  final String message;
  @override
  String toString() => message;
}

/// One-shot GPS capture used by the questionnaire.
class LocationService {
  Future<CapturedPosition> capture() async {
    if (!await Geolocator.isLocationServiceEnabled()) {
      throw const LocationException('Location services are disabled');
    }
    var permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
    }
    if (permission == LocationPermission.denied || permission == LocationPermission.deniedForever) {
      throw const LocationException('Location permission denied');
    }
    final position = await Geolocator.getCurrentPosition(
      locationSettings: const LocationSettings(accuracy: LocationAccuracy.high, timeLimit: Duration(seconds: 30)),
    );
    return CapturedPosition(latitude: position.latitude, longitude: position.longitude, altitude: position.altitude, accuracy: position.accuracy);
  }
}
