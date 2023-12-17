docker build -t pwdgen .
docker run -d -p 8081:80 --name=pwdgen pwdgen
