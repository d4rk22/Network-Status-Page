Network Status Page - 0.0.9
===================

Designed to monitor a local server and network with forecast.io, Plex, and pfSense integration.

Live site: http://d4rk.co/

Plex forum thread: http://forums.plexapp.com/index.php/topic/82978-showing-off-whats-possible-with-plex/

###Screenshots
---------------
![alt tag](https://dl.dropboxusercontent.com/u/493625/Do%20Not%20Delete/d4rk.co.png)

![alt tag](https://dl.dropboxusercontent.com/u/493625/Do%20Not%20Delete/d4rk.co%20-%20now%20playing.png)


###Features
---------------
* Responsive web design viewable on desktop, tablet and mobile web browsers 

* Designed using Bootstrap 3

* Displays the following:
	* currently playing items from Plex Media Server
	* current network bandwidth from pfSense
	* current ping to Google DNS
	* online / offline status for custom services
	* minute by minute weather forecast from forecast.io
	* server load
	* used / total memory
	* total disk space for all hard drives

* Now Playing section adjusts scrollable height on the fly depending on browser window height


###Requirements
---------------
* Plex Media Server (v0.9.8+) and a PlexPass membership
* a web server that supports php (apache, nginx, XAMPP, WampServer, EasyPHP, lighttpd, etc)
* PHP 5.4