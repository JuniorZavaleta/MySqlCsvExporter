# MySql Exporter

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

### Example

On Laravel or a framework with the function env() with the same behavior

The second arg of the constructor are credentials for mysql, check source code

```php
$generator = new CsvGenerator('complaints');

$generator->setTitles(
    'Id',
    'Tipo contaminacion',
    'Distrito',
    'Estado',
    'Fecha de registro'
);

$generator->setColumns(
    'complaints.id',
    'contamination_types.description',
    'districts.name',
    'complaint_states.description',
    'complaints.created_at'
);

$generator->setFilename(storage_path('app/csv/casos_'.date('d_m_Y_H_i_s').'.csv'));

$generator->join('contamination_types', 'complaints.type_contamination_id', 'contamination_types.id')
    ->join('districts', 'complaints.district_id', 'districts.id')
    ->join('complaint_states', 'complaints.complaint_state_id', 'complaint_states.id');

if (!$user->is_admin) {
    $generator->where('complaints.district_id', session('district_id'))
              ->whereNot('complaint_state_id', Complaint::INCOMPLETED);
}

$generator->whereIf('complaint_states.description', request('estado'))
          ->whereIf('districts.name', request('distrito'))
          ->whereIf('contamination_types.description', request('tipo_contaminacion'))
          ->orderBy('complaints.id', 'DESC');

$filename = $generator->execute();

return response()->download($filename)->deleteFileAfterSend(true);

```

Export!
