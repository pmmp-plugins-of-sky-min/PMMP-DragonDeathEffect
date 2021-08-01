# PMMP-DragonDeath

![Screenshot_20210801-123703_Video Player](https://user-images.githubusercontent.com/81374952/127758345-63496890-c2b4-4429-bdf2-edeabb77bc3e.jpg)

## How to use

```php
use skymin\dragon\api\DragonDeathEffect;
```

</br>
player can see the effect

```php
DragonDeathEffect::getInstance()->setEffect(array $player, int|float $x, int|float $y, int|float $z, Level $level, int $tick);
```

Please keep $tick below 120
