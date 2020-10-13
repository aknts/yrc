# yrc
A ultra basic script to push config to multiple Yealink phones 

This specific one just changes the SIP server field for Account 1. Change accordingly to your needs.
The push option must be first enabled on the devices before using the script.
Also the ip address of the server where the scipt resides must be whitelisted again on every device.
Each device is supplied to the function through a two dimensional array.
With the ip address of the device, the firmware version must be also supplied due to differences of the manufacturer api.
Tested with a T20 and T22 phones.
