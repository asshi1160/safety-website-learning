# Safety Website Learning
本サイトはIPAが発行している「[安全なウェブサイトの作り方 改訂第7版](https://www.ipa.go.jp/files/000017316.pdf)」に記載された脆弱性を実際に試し、脆弱性について理解を深める初めの一歩となることを目的に作成されています。一部の脆弱性（メールヘッダ・インジェクション等）については掲載していません。  
脆弱性等の詳細や対策等については、安全なウェブサイトの作り方 改訂第7版を参照してください。

![image](https://github.com/asshi1160/safety-website-learning/assets/104013436/f6336c27-d708-4ef1-944d-884913f31800)

# Setup and Start
コンテナを起動すると自動でDBのデータが生成されます

```
docker-compose up -d
```

# Down
コンテナを削除するとMySQL上のデータは削除されます。  
DB内のデータを初期化したい場合は、コンテナを削除後に再度upしてください。
```
docker-compose down
```

# Access
## Website
http://localhost:18888  
> **Note**  
> 起動直後に[http://localhost:18888/sqli.php](http://localhost:18888/sqli.php)等へアクセスするとMySQLのサービスが起動しておらず下記のエラーを出力することがありますので、その場合は、少し時間を置きサービスが起動するまでお待ちください。
> ```php
> SQLSTATE[HY000] [2002] Connection refused
> ```

## Containers
### php(v8.2)
```
docker exec -it safety-website-php ash
```
### php(v4.4.1)
```
docker exec -it safety-website-php-441 bash
```
### mysql
```
docker exec -it safety-website-mysql bash
```

# SQL logs
`safety-website-learning/Docker/mysql/log/sqli.log`にSQLのログファイルが生成されます。
