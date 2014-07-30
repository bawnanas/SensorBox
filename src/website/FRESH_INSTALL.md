This program will record and display temperatures that its pointed at and send notification 
via email and sms.

using
===== 
	- laravel 3.2.13
	- jquery 1.9.1
	- highstocks v1.2.5 (highcharts.com)
	- mysql (version worked with 14.14 but, Shirley, works  older versions)
	- 'Messages' bundle (https://github.com/loic-sharma/Messages) uses SwiftMailer v4.2.2

requirements: 
	- laravel needs at least php 5.3.*
	- laravel requires mcrypt
	- tables use InnoDB engine (but not required by laravel)
	
	optional requirements:
	- mod_rewrite privileges for pretty urls
	- testing uses PHPUnit

INSTALLATION
============
	quick overview
	---------------
	- unpack laravel_tempest to your public 'www' directory. Unless, that is, you intend to use a virtual
		 host, and have the necessary permissions, you can then install it to any directory of your choosing. 

		$ tar -pxvzf tempest.tar.gz

	- (optional) add a virtualhost

	- delete the key in {project_root}/application/config/application.php
		then run:
			$ php artisan key:generate

	-(optional) set the timezone in application/config/application.php
		to desired timezone using one listed from http://www.php.net/manual/en/timezones.php

	- create a database called tempest_db or you can change the name to your liking in 
		{project_root}/application/config/database.php

	- adjust the credentials in {project_root}/application/config/database.php
		so the database is reachable

	- run artisan migrations from commandline (see Database section)
	- set up cron jobs (see Tasks)

	setting up a Virtual Host (optional)
	-------------------------
	- referenced from http://codehappy.daylerees.com/getting-started
	- in ubuntu the desired file is located in /etc/apache2/sites-available/default
	- add the following where things between {} are variable and specific to your needs:
	- "AllowOverride all" is needed for mod_rewrite, which removes
		'...index.php/...' from urls, making them cleaner 
	<VirtualHost {127.0.0.2}>
    DocumentRoot "{/path/to/laravel/project/}public"
    	ServerName {myproject}
    	<Directory "{/path/to/laravel/project/}public">
        	Options Indexes FollowSymLinks MultiViews
        	AllowOverride all
    	</Directory>	
	</VirtualHost>

	- in etc/hosts add:
		{myproject} {127.0.0.2}
		
	- restart server: sudo service apache2 restart


	Enable Mod Rewrite (optional)
	------------------
		referenced from http://xmodulo.com/2013/01/how-to-enable-mod_rewrite-in-apache2-on-debian-ubuntu.html

		$ sudo a2enmod rewrite

		Then open up the following file, and replace every occurrence of “AllowOverride None” with 
		“AllowOverride all” within your virtual host.

		$ sudo vi /etc/apache2/sites-available/default

		********** don't forget to forget restart apache2: ****************
		$ sudo service apache2 restart

		then in {project_root}/application/config/application.php, change
			'index' => 'index.php' to 'index' => ''


  Database
  ========
 	- create a database called tempest_db
 	- to set up the tables for the database, run the following commands in the command line from
 		the root directory of laravel_tempest:
 		
 		$ php artisan migrate:install
 		$ php artisan migrate


 	- NOTE: some sample data maybe present that may be safely deleted -- though you need to keep
 		the user-"seeded_admin" at least until you have another admin account

 	- if after trying to run php artisan migrate:install you get the error "could not find driver"
 		try running: 
 			$ sudo apt-get install php5-mysql

 		then restart apache2

 	Structure
 	---------
 		assignments -- maintains a relationship between a room and a user. Users can be assigned
 			to multiple rooms, and will only receive notifications for events that occur in the 
 			room they are assigned.
 		+------------+------------------+------+-----+---------+----------------+
		| Field      | Type             | Null | Key | Default | Extra          |
		+------------+------------------+------+-----+---------+----------------+
		| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
		| user_id    | int(10) unsigned | NO   | MUL | NULL    |                |
		| room_id    | int(10) unsigned | NO   | MUL | NULL    |                |
		| created_at | datetime         | NO   |     | NULL    |                |
		| updated_at | datetime         | NO   |     | NULL    |                |
		+------------+------------------+------+-----+---------+----------------+


		carriers -- stores all the domains of the major carriers. Main use is for sending
			sms to a phone. So the structure would be number@domain
		+--------+------------------+------+-----+---------+----------------+
		| Field  | Type             | Null | Key | Default | Extra          |
		+--------+------------------+------+-----+---------+----------------+
		| id     | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
		| name   | varchar(45)      | NO   |     | NULL    |                |
		| domain | varchar(45)      | NO   |     | NULL    |                |
		+--------+------------------+------+-----+---------+----------------+


		device_types -- Maintains a list of the different devices that the system can connect to.
			When adding a new device type, make sure that name of the file matches the one listed here.
		+-------+------------------+------+-----+---------+----------------+
		| Field | Type             | Null | Key | Default | Extra          |
		+-------+------------------+------+-----+---------+----------------+
		| id    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
		| name  | varchar(45)      | NO   |     | NULL    |                |
		+-------+------------------+------+-----+---------+----------------+


		devices -- Stores all data related to a given device. Ensure that when adding or editing
			a device that the ip_address is prepended with 'http://' otherwise it won't be accepted
			by the validation.
		+--------------------+------------------+------+-----+------------------+----------------+
		| Field              | Type             | Null | Key | Default          | Extra          |
		+--------------------+------------------+------+-----+------------------+----------------+
		| id                 | int(10) unsigned | NO   | PRI | NULL             | auto_increment |
		| name               | varchar(45)      | NO   | UNI | NULL             |                |
		| ip_address         | varchar(100)     | NO   | UNI | NULL             |                |
		| warning_threshold  | float            | YES  |     | 80               |                |
		| alert_threshold    | float            | YES  |     | 85               |                |
		| critical_threshold | float            | YES  |     | 90               |                |
		| status             | varchar(45)      | NO   |     | C_N_C            |                |
		| type               | varchar(45)      | NO   |     | TemperatureAlert |                |
		| message_sent       | int(10) unsigned | YES  |     | 0                |                |
		| ports              | int(10) unsigned | YES  |     | 1                |                |
		| room_id            | int(10) unsigned | NO   | MUL | NULL             |                |
		| c_n_c_count        | int(11)          | NO   |     | NULL             |                |
		| warning_count      | int(11)          | NO   |     | NULL             |                |
		| alert_count        | int(11)          | NO   |     | NULL             |                |
		| critical_count     | int(11)          | NO   |     | NULL             |                |
		| created_at         | datetime         | NO   |     | NULL             |                |
		| updated_at         | datetime         | NO   |     | NULL             |                |
		+--------------------+------------------+------+-----+------------------+----------------+


		laravel_migrations -- used by laravel's migrations system
		+--------+--------------+------+-----+---------+-------+
		| Field  | Type         | Null | Key | Default | Extra |
		+--------+--------------+------+-----+---------+-------+
		| bundle | varchar(50)  | NO   | PRI | NULL    |       |
		| name   | varchar(200) | NO   | PRI | NULL    |       |
		| batch  | int(11)      | NO   |     | NULL    |       |
		+--------+--------------+------+-----+---------+-------+


		rooms -- keeps a list of rooms being monitored. Mostly used as a way to group devices
			and users.
		+------------+------------------+------+-----+---------+----------------+
		| Field      | Type             | Null | Key | Default | Extra          |
		+------------+------------------+------+-----+---------+----------------+
		| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
		| name       | varchar(45)      | NO   |     | NULL    |                |
		| created_at | datetime         | NO   |     | NULL    |                |
		| updated_at | datetime         | NO   |     | NULL    |                |
		+------------+------------------+------+-----+---------+----------------+


		temperature_deltas -- keeps a record of the open, close, highs, and lows for a single day.
			Has a foreign key with a device, so if the device is deleted all deltas associated with 
			that device are also deleted.
		+-----------+------------------+------+-----+---------+----------------+
		| Field     | Type             | Null | Key | Default | Extra          |
		+-----------+------------------+------+-----+---------+----------------+
		| id        | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
		| open      | float            | NO   |     | NULL    |                |
		| close     | float            | NO   |     | NULL    |                |
		| low       | float            | NO   |     | NULL    |                |
		| high      | float            | NO   |     | NULL    |                |
		| time      | datetime         | NO   |     | NULL    |                |
		| port      | int(10) unsigned | NO   |     | NULL    |                |
		| device_id | int(10) unsigned | NO   | MUL | NULL    |                |
		+-----------+------------------+------+-----+---------+----------------+


		temperatures -- records the current time and reading of each device and port. Has a foreign key
			from a device, so if that device is deleted all associated temperatures are also deleted.
		+-------------+------------------+------+-----+-------------------+-----------------------------+
		| Field       | Type             | Null | Key | Default           | Extra                       |
		+-------------+------------------+------+-----+-------------------+-----------------------------+
		| id          | int(10) unsigned | NO   | PRI | NULL              | auto_increment              |
		| temperature | float            | NO   |     | NULL              |                             |
		| time        | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
		| port        | int(10) unsigned | NO   |     | NULL              |                             |
		| device_id   | int(10) unsigned | NO   | MUL | NULL              |                             |
		+-------------+------------------+------+-----+-------------------+-----------------------------+


		users -- keeps everything related to a given users, name, password.... . Passwords are hashed before
			being stored.
		+-------------------------+------------------+------+-----+---------+----------------+
		| Field                   | Type             | Null | Key | Default | Extra          |
		+-------------------------+------------------+------+-----+---------+----------------+
		| id                      | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
		| username                | varchar(30)      | NO   | MUL | NULL    |                |
		| password                | varchar(60)      | NO   | MUL | NULL    |                |
		| email                   | varchar(255)     | NO   | MUL | NULL    |                |
		| email_verified          | tinyint(1)       | NO   |     | 0       |                |
		| phone                   | varchar(20)      | YES  |     | NULL    |                |
		| carrier                 | varchar(45)      | YES  |     | NULL    |                |
		| phone_verified          | tinyint(1)       | NO   |     | 0       |                |
		| email_verification_code | varchar(5)       | YES  |     | NULL    |                |
		| phone_verification_code | varchar(5)       | YES  |     | NULL    |                |
		| is_admin                | tinyint(1)       | YES  |     | 0       |                |
		| created_at              | datetime         | NO   |     | NULL    |                |
		| updated_at              | datetime         | NO   |     | NULL    |                |
		+-------------------------+------------------+------+-----+---------+----------------+



  Tasks (i.e. cron jobs) 
  ========
  	- tasks are located in {project_root}/application/tasks
  	- there are currently 3 tasks that should be set up as a cron job
  		get_temperatures 
  		send_notifications
  		generate_report

  	- to add a cronjob:
		$ crontab -e
	
	then edit the file:
	 */{desired_frequency} * * * * php /{project_root}/artisan get_temperatures
	 */{desired_frequency} * * * * php /{project_root}/artisan send_notifications
	 0 5 * * {desired_day} php /{project_root}/artisan generate_report

	 Its recommend that get_temperatures and send_notifications are set to run every 1-5, but may be set
	 	to something less frequent if so desired. setting the wildcard, {desired_frequency}, in the above 
	 	example would set it to run every few minutes. 

	 Its recommended that generate_report be run weekly. Setting the wildcard, {desired_day}, in the above
	 	example would set it to run whatever day (0-6) at 5 a.m.


	get_temperatures
	----------------
	Goes through all devices and ports and tries to get the current reading and store it in the database.
	Currently there is only one official device type that is supported, TemperatureAlert. However, it is easily extensible. To add a new type:
		- from the details page, add a new device_type
		- add it to the ParserFactory.php build function
		- write its class, extend from ITemperatureParser, and ensure that has the following methods:
			- is_connected() // a way to verify that device is reachable
			- get_temperature($port_num)


	send_notifications
	------------------
	will send a notification to all users assigned to the room where the event occured.
	The frequency should be the same as the 'get_temperatures' task, and set up to run after it.

	generate_report
	---------------
	Creates a file that is stored in {project_root}/reports, and sends a copy to all admins' email.
	Data included in the file are basic information about a device, such as, all status counts and
	min, max, and average temperature reading from each port for the past week. All counts are reset
	on the completion of generating the report.

	It will also show rooms that have no one assigned to them as well as unconfirmed user contact info.



	Adding a new Task
	-----------------
	To add a new task, simply add a new file in the {project_root}/application/tasks folder (don't forget 
	to check permissions. The class name of your task should have '_Task' appended to it, and have a public
	function run($arguments)

	class Some_Task
	{
		public function run($arguments)
		{
			//do stuff
		}
	}

	see laravel's documentation for more details.





Graphs
======
	Graphs are created using the Highstock library. The graphs can be found in 
	{project_root}/public/js. Further documentation and extensive examples can be found 
	at http://www.highcharts.com/.


 Logs
 ====
 	- for more information see: http://laravel.com/docs/errors
 	- all logs are written to {project_root}/storage/logs and are organized by date
 	- to write to the log 
 		Log::write($type, $message);
 			where $type can be 'info', 'warning', or 'error'
 			and $message is what ever needs recording
 	- currently logging errors and all device states that aren't 'OK'

Testing
=======
	- laravel uses PHPUnit for unit testing. 
	- to check if phpunit is install:
		$ phpunit --version

	- if phpunit is not installed:
		$ sudo apt-get install php-pear
		$ sudo pear upgrade PEAR
		$ sudo pear config-set auto_discover 1
		$ sudo pear install pear.phpunit.de/PHPUnit


	- tests a located in {project_root}/application/tests
	- to run the tests, simply run:
		$ php artisan test

	- testing documentation specific to laravel can be found in {project_root}/laravel/documentation/testing.md
	- phpunit documentation can be found at http://phpunit.de/manual/current/en/

Mail
====
	- using the messages bundle which has swiftmailer under the hood
	- currently set to use google, this can be changed in /bundles/messages/config/config.php 


Adding A DeviceType
===================
	Currently only set up with one device type, TemperatureAlert, and another sample data generator.
	To add a new device to the system, from the details page, click on 'Add DeviceType' then give it
	a name and submit. 

	Then create a new file in /application/tasts with the same name with '.php' appended.
	The class name should be the same as the name in the database and should implement the ITemperatureParser.

	The interface requires only 2 methods be implemented:
		is_connected() (some way to determine if the device is connectable)
		get_temperature($port) (get the current reading of a port of the device)

	Now add it to the ParserFactory.php
	  ...
		elseif( $type === "DeviceTypeName")
		{
			return new DeviceTypeName('dummy argument');
		}
	  ...

	(and yes, you're right, this should be automated... sorry)

Misc
=====

permissions: currently setup has it at 775 for /var/www/laravel_tempest - don't know if
	this is the best but it's working, and its not 777? and 765 seems to have problems
			 $ chmod -R 775 {project_root}
known problem fixes:

	/laravel/storage requires read write access
		fix-- 
		from command-line:
			 $ chmod -R o+w .../storage

	- if you're having trouble routing to a newly created controller, check the permissions of that file!
	- also, if you're still having problems, try checking the routes listed ABOVE the route that's
		giving you trouble and ensure that they all work. This seemed to fix a problem I was having,
		but after coming back and testing it, it didn't seem to have much effect, so worth a shot, 
		but don't hold your breath.

	- the mysterious e() e.g. e($room->name):
		this is actually short and for HTML::entities() which will escape all special 
		characters. though the validations should prevent most, if not all, special
		characters from appearing in names and other fields, this is just another layer
		of protection.

	- if you're having problems when making changes to files, but keep getting the same error despite
		reverting changes or otherwise, try deleting files in /storage/views. views are generated, stored,
		and retrieved from here to speed things up.
