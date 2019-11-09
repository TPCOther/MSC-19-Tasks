# Schedule with UI
## Env
- php 7
- php composer
- python 2/3

## Usage

1. Run <code>$ composer install</code> to install the dependencies of this project.
2. Visit <code>[host]/get.php?id=[STUID]&pass=[RAW_PASSWORD]</code>
3. Visit <code>[host]/cal.php?id=[STUID]</code>

## Notifications
1. Never put this project onto a factory environment! It's written without necessary secruity measures to prevent injections.
2. Running this project needs to use function <code>system()</code>, if not working, check if system() is blocked. (It should be blocked, please leave it blocked as possible)
3. Due to my laziness, the password is transported **without classification**. Don't use this website in an unsafe environment.
4. If possible, **NEVER RUN IT**.

---
# Only2ICS
This is a safe function. It only translate the schedule into ICS.

## Usage
1. Run <code>$ composer install</code> to install the dependencies of this project.
2. Open the php file ```Only2ICS.php```
3. Change the config from line 21 to line 23:
```php
/*
 * stuID : string, student id
 * schoolCode : No need to change(for cqu users)
 * pass : raw password without classification
 */
$stuID = "20194134";
$schoolCode = "10611";
$pass = "password";
```
3. Run it via terminal 
```linux
$ php Only2ICS.php
```
4. Find your ICS file in ```./store/[STUID].ics```
5. Import it to your calendar

---
# Refs (Main)
- Material Pro Admin
- iCal https://github.com/markuspoerschke/iCal
- FullCalendar https://fullcalendar.io
- icalendar2fullcalendar https://github.com/leonaard/icalendar2fullcalendar
---
# 20194134 于卓浩