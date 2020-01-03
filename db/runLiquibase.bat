@echo off

set CHANGELOG_FILENAME=db.changelog.xml
set DB_SERVER=localhost
set DB_NAME=sym
set DB_USER=root
set DB_PASSWORD=""

liquibase --driver="com.mysql.jdbc.Driver" --classpath="./mysql-connector-java-5.1.48-bin.jar" --changeLogFile=%CHANGELOG_FILENAME% --url="jdbc:mysql://%DB_SERVER%/%DB_NAME%" --username=%DB_USER% --password=%DB_PASSWORD% update >liquibase.log

pause