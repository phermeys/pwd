docker kill pwdtest2
docker rm pwdtest2
docker build -t pwdtest2 .
docker run -d --name pwdtest2 -p 9023:80 -v ./mysql:/opt/sqlback pwdtest2
