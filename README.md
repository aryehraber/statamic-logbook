# Logbook

**View log files in the CP**

Viewing log files directly on the server can be a bit of a hassle... First you have to `ssh` in, `cd` to the project's logs directory, and finally open each one only to see the biggest mangle of info logs and error logs with stack traces.

Logbook solves this by displaying each log file in a table and collapsing the stack traces to keep things nice and tidy.
You can view a full stack trace by clicking on it.

<img src="https://github.com/user-attachments/assets/10d4ed26-1218-46f0-92ef-c01114dd8ed0" alt="Logbook" width="700">

## Installation

Install the addon via composer:

```
composer require aryehraber/statamic-logbook
```

That's it! Logbook can now be accessed via the CP under `Tools > Utilities`.
