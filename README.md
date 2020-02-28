# Демо реализация получения курса валюты

В демо контроллере CurrencyController внедряем зависимость от CurrencyProvider (Фасад).

Для получения текущего курса вызываем у CurrencyProvider метод getCurrency.

CurrencyProvider работает с :
  - CacheProvider $cacheProvider (получение из Кэш);
  - DbProvider $dbProvider (получение из БД);
  - ForeignSourceProvider $scrProvider (получение из внешнего источника).

В классе CurrencyProvider в его методе getCurrency реализована логика последовательного получения
курса валюты из Кэш, БД, внешного источника.

Если не удалось получить из Кэш, проверяется БД, далее внешний источник.
При удаче на каждом этапе начиная с БД результат сохраняется в Кэш и БД.
