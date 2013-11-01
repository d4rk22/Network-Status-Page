Network Status Page - 0.1.0
===================

Designed to monitor a local server and network with forecast.io, Plex, and pfSense integration.

[Live site][ls]

[Plex forum thread][pft]

[ls]: http://d4rk.co/
[pft]: http://forums.plexapp.com/index.php/topic/82978-showing-off-whats-possible-with-plex/

###Screenshots
---------------
![alt tag](https://dl.dropboxusercontent.com/u/493625/Do%20Not%20Delete/d4rk.co.png)

![alt tag](https://dl.dropboxusercontent.com/u/493625/Do%20Not%20Delete/d4rk.co%20-%20now%20playing.png)


###Features
---------------
* Responsive web design viewable on desktop, tablet and mobile web browsers 

* Designed using [Bootstrap 3][bs]

* Uses jQuery to provide near real time feedback

* Optimized for OS X Mavericks `Tested on OS X 10.9 and Safari 7.0 and iOS 7.0.3 on iPhone/iPad.`

* Displays the following:
	* currently playing items from Plex Media Server
	* current network bandwidth from pfSense
	* current ping to Google DNS
	* online / offline status for custom services
	* minute by minute weather forecast from forecast.io
	* server load
	* used / total memory
	* total disk space for all hard drives

* Weather forecast only shows while viewing from local network

* Now Playing section adjusts scrollable height on the fly depending on browser window height


[bs]: http://getbootstrap.com



###Requirements
---------------
* [Plex Media Server][pms] (v0.9.8+) and a [PlexPass][pp] membership `These are both free.`
* The weather sidebar requires a [forecast.io API key][fcAPI] 
```The forecast.io API is free for the first 1000 API calls per day. Every API call after that costs $1 per 10,000 (that is, 0.01¢). I average 300-400 calls per day and have only ever gone over 1000 when debugging and have never needed to provide billing info.```
* Web server that supports php (apache, nginx, XAMPP, WampServer, EasyPHP, lighttpd, etc)
* PHP 5.4

**Note:** While this project is written with OS X in mind, it can very easily be adapted to run on linux or windows
by rewriting the functions that don't work on those platforms.
[pms]: http://www.plexapp.com/desktop/
[pp]: https://my.plexapp.com/subscription/about
[fcAPI]: https://developer.forecast.io

###Optional
---------------
* A few functions are written to be used with the following software but they are optional:
	* [SABnzbd+][sab]
	* [pfSense][pfs]

[sab]: http://sabnzbd.org
[pfs]: http://www.pfsense.org