import 'dart:io';

Future<String?> getIpAddress() async {
  for (var interface in await NetworkInterface.list()) {
    for (var addr in interface.addresses) {
      if (addr.type == InternetAddressType.IPv4) {
        return addr.address;
      }
    }
  }
  return null;
}

void main() async {
  String? ipAddress = await getIpAddress();
  print("Local IP Address: $ipAddress");
}
