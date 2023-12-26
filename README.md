# pwd.theregion.beer
Password Generator I built a while ago because I was sick of doing it manually

Old version had multiple containers, new verion is single container.

I have now dockerized it, and this can be run thusly. Once complete, it will be accessible at `http://localhost:8503`

Local port can be changed in the docker-compose file for now

The container also exports the current database every hour, and it exports it to the original import location.

The database is initialized entirely in the docker compose file, so the hash database should persist through reboots. 

To deploy from fresh database with no old hashs, overwrite the `pwdgen-hashs.sql` file with the `pwdgen.sql` in the `mysql` folder to  before bringing up the container.

```
git clone https://github.com/phermeys/pwd.git
cd pwd
docker-compose up -d
```
