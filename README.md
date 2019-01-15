[![CircleCI](https://circleci.com/gh/Northernberg/The-office.svg?style=svg)](https://circleci.com/gh/Northernberg/The-office)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Northernberg/The-office/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Northernberg/The-office/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Northernberg/The-office/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Northernberg/The-office/build-status/master)

Installation
===============
Git clone git@github.com:Northernberg/The-office.git folder

Setup database
==============
mysql -uuser -ppass theofficedb < sql/ddl/setup-db.sql
mysql -uuser -ppass theofficedb < sql/ddl/user_mysql.sql
