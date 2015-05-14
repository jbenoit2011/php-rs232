php-rs232 0.1.0-alpha
=====================

:warning:
**This library is still at alpha stage.
Not every features have been tested.
Use it at your own risk.**

This library allows to communicate with devices through RS232 protocol.

## Quick start

Refer to tests folder.

## Features
- All parity mode supported: none, odd, even
- All flow control mode supported: none, xon/xoff, rts/cts
- Baud rate supported: 110, 150, 300, 600, 1200, 2400, 4800, 9600, 19200, 38400, 57600, 115200
- Character length supported: 5, 6, 7, 8
- All Stop bits supported: 1, 1.5, 2
- Supports OSX

Tested with a serial loopback made from an Arduino One R2 on OSX Mavericks.

## Requirements

- PHP 5.3+

## Issues

If you encounter any issues, make sure it does not come from your setup.
Then, fill an issue on GitHub repository.

## License

This work is under LGPL 3.0. You can find a copy in [LICENSE](LICENSE)

## Contributing

All contributions are welcomed. If you wish to participate, follow these steps:
1. Fork the repository
2. Create a branch
3. Commit your changes and push them to the GitHub fork
4. Send a pull request

:warning: Any pull request MUST be accompanied with tests.

**Please follow PSR-2 coding standards.**

# Credits

Heavily inspired from [Xowap/PHP-SERIAL](https://github.com/Xowap/PHP-Serial)
