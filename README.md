# Dframe/ActivityLog

[![Latest Stable Version](https://poser.pugx.org/dframe/activitylog/v/stable)](https://packagist.org/packages/dframe/activitylog) 
[![Latest Unstable Version](https://poser.pugx.org/dframe/dframe/v/unstable)](https://packagist.org/packages/dframe/activitylog) 
[![License](https://poser.pugx.org/dframe/dframe/license)](https://packagist.org/packages/dframe/dframe)


**Documentation available at** [https://dframeframework.com](https://dframeframework.com/en/page/index)

Language
[Polish](https://dframeframework.com/en/page/docs) | [English](https://dframeframework.com/en/page/docs)

### Installation Composer

```sh
$ composer require dframe/activitylog
```


PSR-3 Adapter
```php
use Dframe\ActivityLog\Activity;
use Dframe\ActivityLog\Demo\Drivers\PSR3FileLog;
use Dframe\ActivityLog\Helper\Psr3Adapter;
use Psr\Log\LogLevel;

require_once __DIR__ . '/../../vendor/autoload.php';

$log = new Activity(new PSR3FileLog());

$logger = new Psr3Adapter($log, 'System', \Dframe\ActivityLog\Entity\PSR3::class);
$logger->log(LogLevel::ERROR, 'This is {error}', ['error' => 'error #500']);
```

Standard Usage 

```php
use Dframe\ActivityLog\Activity;
use Dframe\ActivityLog\Demo\Drivers\FileLog;

require_once __DIR__ . '/../../vendor/autoload.php';

$log = (new Activity(new FileLog()));
$log->log('Hello Word!')->entity(\Dframe\ActivityLog\Demo\Entity\Action::class)->push();
```

Display Logs
```php
$log->logs();
```
