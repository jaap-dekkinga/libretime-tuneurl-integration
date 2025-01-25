# [![LibreTime](https://github.com/libretime/website/blob/main/static/img/logo-512px.png)](https://github.com/libretime/libretime)

To setup Libretime app in local, Please follow these steps

Install docker and docker-compose using below link
•	https://libretime.org/docs/admin-manual/install/install-using-docker/

Setup Libretime app using below link 
    https://libretime.org/docs/admin-manual/install/install-using-docker/

Install Apache using below link
    https://ubuntu.com/tutorials/install-and-configure-apache

Setup reverse proxy using below link
    https://libretime.org/docs/admin-manual/install/reverse-proxy/

Install SSL certificate by adding below lines in default-ssl.conf file
    SSLEngine on
    SSLCertificateFile      /home/ubuntu/tuneurl-demo.com_ssl_certificate.cer
    SSLCertificateKeyFile   /home/ubuntu/_.tuneurl-demo.com_private_key.key
    <Location />
            ProxyPass           http://localhost:8080/
            ProxyPassReverse    http://localhost:8080/
    </Location>


Update config.yml file to stream mp3 format audio. in Icecast section change ogg format to mp3 in first stream for this and enable second stream

 audio:
          format: mp3
          bitrate: 256


Enable 8443 port by adding below line in Ports..conf

    Listen 8443

Create 8443-to-8000.conf file by using below command to redirect 8433 port connection to 8000

    sudo vi /etc/apache2/sites-available/8443-to-8000.conf

then add this content in this file
    <VirtualHost *:8443>
        ServerName ec2-18-119-105-1.us-east-2.compute.amazonaws.com

        SSLEngine on
        SSLCertificateFile      /home/ubuntu/tuneurl-demo.com_ssl_certificate.cer
        SSLCertificateKeyFile   /home/ubuntu/_.tuneurl-demo.com_private_key.key

        <Location />
            ProxyPass           http://localhost:8000/
            ProxyPassReverse    http://localhost:8000/
        </Location>

        ErrorLog ${APACHE_LOG_DIR}/8443-error.log
        CustomLog ${APACHE_LOG_DIR}/8443-access.log combined
    </VirtualHost>

Enter in mysql container by running below command. where 8a3bb21dec80 is mysql container id
     docker exec -it 8a3bb21dec80 bash

Add tuneurl_id column in playlistcontents Table so that tuneurl id can be saved in the Database when the Tuneurl is created

ALTER TABLE cc_playlistcontents ADD tuneurl_id INTEGER NULL;

Run this docker command to setup the app

    docker-compose run --rm api libretime-api migrate

Finally, start the services, and check that they're running using the following commands:

    docker-compose up -d

    docker-compose ps
    docker-compose logs -f



Check the docker conatiner id by running below command

     docker-compose ps

Then use that container id to copy local file fromj this repo in docker container
    For Legacy container
•	  sudo docker cp playlist.phtml eba6897eb5d1:var/www/html/application/views/scripts/playlist/playlist.phtml
•	  sudo docker cp update.phtml eba6897eb5d1:var/www/html/application/views/scripts/playlist/update.phtml
•	  sudo docker cp dashboard.js eba6897eb5d1:var/www/html/public/js/airtime/dashboard/dashboard.js
•	  sudo docker cp spl.js eba6897eb5d1:var/www/html/public/js/airtime/library/spl.js
•	  sudo docker cp library.js eba6897eb5d1:var/www/html/public/js/airtime/library/library.js
•	  sudo docker cp playlist_builder.css eba6897eb5d1:var/www/html/public/css/playlist_builder.css
•	  sudo docker cp loader.gif eba6897eb5d1:var/www/html/public/images/loader.gif
	
•	  sudo docker cp RabbitMq.php eba6897eb5d1:var/www/html/application/models/RabbitMq.php
•	  sudo docker cp Playlist.php eba6897eb5d1:var/www/html/application/models/Playlist.php
•	  sudo docker cp PlaylistController.php eba6897eb5d1:var/www/html/application/controllers/PlaylistController.php
•	  sudo docker cp CcFiles.php eba6897eb5d1:var/www/html/application/models/airtime/CcFiles.php
•	  sudo docker cp MediaController.php eba6897eb5d1:var/www/html/application/modules/rest/controllers/MediaController.php
•	  sudo docker cp MediaService.php eba6897eb5d1:var/www/html/application/services/MediaService.php
•	  sudo docker cp BaseCcBlockcontents.php eba6897eb5d1:var/www/html/application/models/airtime/om/BaseCcBlockcontents.php
•	  sudo docker cp BaseCcBlockcontentsPeer.php eba6897eb5d1:var/www/html/application/models/airtime/om/BaseCcBlockcontentsPeer.php
•	  sudo docker cp BaseCcPlaylistcontents.php eba6897eb5d1:var/www/html/application/models/airtime/om/BaseCcPlaylistcontents.php
•	  sudo docker cp BaseCcPlaylistcontentsPeer.php eba6897eb5d1:var/www/html/application/models/airtime/om/BaseCcPlaylistcontentsPeer.php
•	  sudo docker cp CcPlaylistcontentsTableMap.php eba6897eb5d1:var/www/html/application/models/airtime/map/CcPlaylistcontentsTableMap.php
    
    For Analyzer container
•	  sudo docker cp message_listener.py   43e67190ab9c:src/libretime_analyzer/message_listener.py
•	  sudo docker cp pipeline.py 		  43e67190ab9c:src/libretime_analyzer/pipeline/pipeline.py
•	  sudo docker cp analyze_replaygain.py 43e67190ab9c:src/libretime_analyzer/pipeline/analyze_replaygain.py
•	  sudo docker cp _ffmpeg.py            43e67190ab9c:src/libretime_analyzer/pipeline/_ffmpeg.py

Upload Trigger-Audio.mp3 file using Upload button in Libretime app. then run this query to update the trigger audio metadata

update cc_files set mime='audio/mp3', ftype='audioclip', filepath='imported/1/Trigger-Audio.mp3', import_status=0, bit_rate=16000, sample_rate=11025, length='00:00:01.52', cueout='00:00:01.52' where id=1;

update cc_files set  length='00:00:01.44', cueout='00:00:01.44', filesize=58618, bit_rate=326395, channels=2 where id=1;













