# MySqlGenerator

Create a csv file from mysql

## Installation

composer require

## Mysql Configuration

Add the csv folder to file /etc/apparmor.d/usr.sbin.mysqld

```
/usr/sbin/mysqld {
    [...]
    # Allow data files dir access
    /var/lib/mysql-files/ r,
    /var/lib/mysql-files/** rwk,

    /path/to/project/csv/ r,
    /path/to/project/csv/* rwk,
    [...]
}
```

then run

```
sudo /etc/init.d/apparmor reload
```

Maybe have problems with secure-file-priv, change on mysql config

```
[mysqld]
secure-file-priv = ""
```

```
sudo service mysql restart
```

Export!
