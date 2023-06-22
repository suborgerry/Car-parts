<?
$aTip = Array(
	1 => 'Список всех производителей OEM/Аналогов запчастей <b>доступных</b> для добавления и использования в модуле',
	2 => 'Используйте "Псевдонимы" что бы привязывать цены к единому бренду который может иметь разные наименования в у поставщиков.',
	3 => 'Список производителей, <b>доступных</b> для добавления в вашу локальную базу CarMod',
	4 => 'Список производителей уже <b>добавленных</b> в вашу локальную базу и используемых модулем CarMod. Можете удалить запись производителя и потом снова добавить если потребуется.',
	5 => 'Влияет на сортировку товаров в списке. Значение от 1 до 999',
	6 => 'Альтернативные названия бренда (или префиксы) которые могут быть в прайсах поставщиков. Помогают правильно загрузить цены для данного номинального наименования бренда',
	7 => '',
	8 => 'Внимание! При отключении языка будут удалены все его языковые фразы, наименования товаров и разделов', 
	9 => 'Вы можете создать собственный шаблон в /'.CM_DIR.'/templates/.. скопировав и переименовав шаблон "default". Не редактируйте шаблон "default" так как он регулярно перезаписывается системой авто-обновлений',
	10 => 'Вы можете добавить собственный скрипт интеграции с вашей CMS в /'.CM_DIR.'/tocms/.. или скопировать и переименовать существующий для ваших модификаций. Учтите что скрипты интеграции находящиеся в данной папке по умолчанию - могут быть перезаписаны системой авто-обновлений модуля. Но ваши собственные и переименованные скрипты не будут перезаписаны при обновлениях',
	11 => 'Каждый раз когда вы заходите в админ-часть будет выполнен запрос курса валюты нацбанка. Вы можете добавлять или менять методы для любой валюты в /'.CM_DIR.'/core/exrates.php',
	12 => 'Этот html DOM элемент используется в скрипте AJAX добавления товаров в корзину /'.CM_DIR.'/templates/default/includes.php как PHP константа: CmsCartID<br>JavaScript выполняемый после обновления контента корзинки следует добавлять в /'.CM_DIR.'/templates/default/custom.js в функции CmAfterCartAjax()',
	13 => 'Будет показано "В наличии" или "Нет в наличии"',
	14 => 'Шаблоны модуля располагаются в папке /'.CM_DIR.'/templates/.. Не следует редактировать шаблон "<b>default</b>" так как он постоянно <b>перезаписывается</b> системой авто-обновлений. Что бы создать собственный шаблон - скопируйте и переименуйте (по FTP) шаблон "default" а затем переключитесь на него в админ-части модуля, в основных настройках',
	15 => 'Фиксировання сумма которая будет применена к исходной загруженной цене. Учтите что исходная цена хранится в той валюте в которой была загружена и наценка/скидка будет применена именно к исходной цене в этой валюте',
	16 => 'CSS код цвета (6 символов) основных элементов шаблона используемый в /'.CM_DIR.'/templates/default/includes.php',
	17 => 'Когда клиент заходит впервые в каталог, он увидит его в этом языке. Если в CMS добавлен переключатель языка и в скрипте интеграции CMS присутствует php код переключения на язык CMS - то каталог уже будет показан в выбранном пользователем языке',
	18 => 'То же самое что и "Язык по умолчанию" выше, только применимо к валюте',
	19 => 'Вы не можете удалить Правило Наценок - так как оно привязано к Типу Цены',
	20 => 'Дополнительно оплачиваемый сервис для одной страны',
	
	21 => 'Любые латинские символы. Используется как дополнительная метка для связки с другими данными базы, фильтрации, поиска, удаления и тп',
	22 => 'Скрипт с запросом вебсервиса, расположенный в папке /'.CM_DIR.'/webservices/ который принимает входящие переменные и должен вернуть структурированный массив цен $aPrices',
	23 => 'Ваш Логин или Номер клиента который как правило вам выдает поставщик вебсервиса. Обратите внимание что он не всегда совпадает с логином вашего кабинета на сайте поставщика и может выдаваться отдельно по запросу',
	24 => 'Дополнительный параметр который возможно необходим для аутентификации',
	25 => 'Цена для данного товара будет сохранена в базе модуля на указанное время. Рекомендуем кэшировать цены хотя бы на 1 день. Это значительно ускорит работу каталога и уменьшит нагрузку на вебсервис',
	26 => 'Если у провайдера вашего вебсервиса есть суточный лимит запросов, укажите его обязательно. Иначе вас могут заблокировать за превышение квоты',
	27 => 'Если ваш вебсервис возвращает по запрошенному Артикул+Бренд так же Аналоги (Кроссы), вы можете сохранить эти записи в модуле для их последующего импорта в базу каталога',
	28 => 'Включить так же запрос цен только по Артикулу, без уточнения Бренда. Такой запрос может быть более долгим - зависит от архитектуры вебсервиса. Можете отключить в крайнем случае для оптимизации скорости работы модуля',
	29 => 'Если вебсервис возвращает наименования товаров, вы можете сохранить их в отдельную таблицу модуля',
	30 => 'В карточке товара (только для админа) будет показана ошибка если она есть при запросе цен данного товара. Удобно для тестов и отладки',
	31 => 'Если для данного товара уже загружена меньшая цена ЛЮБОГО поставщика/вебсервиса то цена выше - не будет добавлена. Эта опция может замедлить работу каталога если у вас загружены сотни тысяч (миллионы) цен и если у вашего хостинга/сервера слабые настройки MySQL/RAM/CPU',
	32 => 'Визуальное текстовое значение которое видит покупатель. Не участвует в логике',
	33 => 'Числовое значение, не выводится публично, участвует в логике',
	34 => 'На вашем хосте/сервере должен быть открыт порт 993 для SSL соединения с почтовым IMAP сервером. Так же разрешите удаленные подключения к вашему почтовому ящику в настройках на сайте почты',
	35 => 'Используйте знак * что бы указать им маску любого текста',
	36 => 'Будет выбрано только Одно письмо совпавшее по Теме и Отправителю - у которого самая последняя дата',
	37 => 'Любое, неповторяющиеся название (En). Используется в логике модуля',
	38 => 'Если указать неправильную кодировку файла, то может некорректно отображаться содержимое файла',
	39 => 'Файл может содержать заглавные строки с описанием колонок, чтобы их пропустить укажите с какой строки начать импорт',
	40 => 'Создастся файл в котором будет записаны все пропущенные строки с прайс листа во время импорта. После импорта его можно скачать',
	41 => 'Если вам нужен в каталоге поиск от раздела, то активируйте эту опцию. Импорт будет длиться дольше, потому что тянет привязку каждого товара к разделу с удаленного сервера',
	42 => 'Всегда будет загружаться найменьшая цена. Если в базе данных модуля уже есть цены на данный товар, то будет оставлена найменьшая цена, остальные удалены. В итоге на товары с данного прайс листа будет только по 1 цене',
	43 => 'Видимое значение может содержать любой вид (10шт, 10+ ...). Это то что видит клиент при покупке товара. Второе поле - числовое, то что участвует в логике модуля. Обязательно цифра',
	44 => 'Если в пункте "Колонки" активирована привязка разделов, то шаг импорта ограничен до 100',
	45 => 'Правило наценок можно создать в разделе "Настройки цен"',
	46 => 'Ваши данные сохраняются на наших серверах. При переустановке модуля вы можете синхронизировать и обновить активные бренды. Таким образом вы не теряете список брендов с которым работаете',
	47 => 'Вместо блока цен, у товара, будет выведена кнопка "Узнать цену" при клике на которую будет перенаправление по ссылке указанной в шаблоне',
	48 => 'Относительная или абсолютная ссылка кнопки "Узнать цену". Используйте шаблонные значения из таблицы ниже - которые будут заменены в ссылке на значения Бренда и Артикула товара',
	49 => 'Набор символов которые следует удалить из названий Брендов и Артикулов. Например: пробелы, точки, скобки и тп.',
	50 => 'Каждый просмотр страницы регистрируется в журнале модуля. Если просмотров будет больше установленного значения в час/сутки, то такой пользователь будет помечен ботом - сканирующим сайт. Для такого посетителя часть данных не будет выводиться за ненадобностью. Например цены и доп. характеристики товаров - что значительно уменьшит нагрузку на CPU, траффик и Базы данных. Внизу публичной части модуля для такого посетителя, для отладки, будет выведено текстом: [data limited]',
	51 => 'Использовать CSS для узкого дизайна шаблона. Подходит для шаблона вашей CMS в которой есть боковая колонка меню - ограничиваюшая ширину контентной области',
	52 => 'Запрещается загружать изображения содержащие любой водяной знак (какого либо веб-сайта), кроме знака самого Бренда запчасти',
	53 => 'Sitemaps — XML-файлы с информацией для поисковых систем (таких как Google, Яндекс..) о страницах веб-сайта, которые подлежат индексации. Sitemaps могут помочь поисковикам определить местонахождение страниц сайта для того, чтобы поисковая машина смогла более разумно индексировать сайт.
Использование протокола Sitemaps не является гарантией того, что веб-страницы будут проиндексированы поисковыми системами, это всего лишь дополнительная подсказка для сканеров, которые смогут выполнить более тщательное сканирование сайта.',
	54 => 'Не рекомендуется использовать чаще чем 1 раз в сутки',
	55 => 'Включайте только если ссылки на вашем сайте настроены через .htaccess на работу с приставкой активного языка',
	56 => 'Будет сгенерирована ссылка на каждый товар имеющий цены. Товары не имеющие цены не попадут в Sitemap так как их миллионы, что создаст слишком большие файлы Sitemap и ненужные ссылки',
	57 => 'Возможно,потребуется много памяти PHP. Если вы увидите ошибку "<b>Fatal error: Allowed memory size of</b> .." - значит необходимо выделить для PHP больше памяти (параметр "<b>memory_limit</b>" в php.ini или в настройках хостинга)',
	58 => 'Вместо кнопки "В корзину" будет выведена кнопка "Заказать" - при клике на которую всплывает окно с полями быстрого заказа товара с отсылкой сообщения на E-Mail Админа (указывается в основных настройках). При этом товар не ложится в корзину CMS. Под данной кнопкой используется аддон /'.CM_DIR.'/add/mail_order/.. шаблоны которого вы можете создавать и редактировать (кроме "default", так как он перезаписывается Системой Обновлений)',
	59 => 'Это <b>фактическое</b> количество цен загруженных на данный момент в вашу локальную базу. Учтите что слева в колонке указано количество цен которые <b>были загружены</b> в последний раз этим шаблоном импорта. Затем вы могли <b>удалить</b> цены с базы... Но запись сколько их было добавлено все равно сохраниться и будет не совпадать с текущим фактическим количеством цен.',
	60 => 'Если это сокращенное (короткое/альтернативное) название уже существующего в базе Бренда - то включите OFF и укажите его ниже в поле',
	61 => 'Укажите ссылку на Вебсайт нового Бренда. Тогда мы сможем его добавить в базу',
	62 => 'На всех страницах модуля (сверху над контентной частью) будет подключен шаблон аддона /'.CM_DIR.'/add/header/..',
	63 => 'Если вебсервис не вернул цены по запрошенному Артикулу - то старая цена не будет удалена с базы',
	64 => 'Поиск по номеру запчасти имеет следующую логику:<br>1) Если найден только <b>один</b> товар - то будет <b>перенаправление</b> на карточку этого товара.<br>2) Если найдено <b>несколько</b> совпадений по артиклу  (количество можно настраивать) - то будет выпадающий список с выбором какой именно <b>Бренд и тип</b> запчасти ищет покупатель.<br>3) Если включена опция "Показать результат поиска с аналогами" - то список результата будет дополнен так же и <b>множеством подходящих аналогов</b> по артикулам которые совпали с искомым номером.',
	65 => 'Перенаправить по ссылке содержащий только первый ОЕ номер вместо самого Артикула данного товара',
	66 => 'Всё равно показать цены и кнопку Корзины',
	67 => 'Базовый, оптовый и другие типы цен которые вы можете добавить в разделе "Настройки цен"',
	68 => 'Цена после применения всех наценок',
	69 => 'Именно целочисленное значение поля DELIVERY_NUM. Не путать с текстовым полем DELIVERY_VIEW визуального представления ("завтра" или "2-3 дня" и т.п.)',
	70 => 'PriceID формируется из полей цены (таблица CM_PRICES_NEW). <b>Логика обновления</b> цен зависит от того какие поля вы выбирете как ключевые. Например, если ваш поставщик на одну и туже запчасть предлагает <u>несколько</u> цен с разными Сроками доставки - то включите поле "Срок поставки" в формирование ключа цены. Иначе у вас всегда будет <u>только одна</u> цена на данную запчасть от данного поставщика. Этот же принцип относится и к остальным полям',
	71 => 'Например, при поиске по номеру "986494107" так же будет искать и по его номинальному "0986494107" с ведущим нулем',
	72 => 'Дополнительное SEO описание/наименование товара которое загружается с Прайс-листом, через API вебсервиса поставщика или добавляется вручную',
	73 => 'Редактирование раздела (активность, сортировка и удаление) будет применяться для всех языков',
	74 => 'Список Брендов которые не активированы в <a href="Brands.php">настройках брендов</a>. Возможно, Бренд уже есть в системе, но под другим наименованием. Тогда вы можете добавить для него псевдоним (алиас) что бы привязать произвольное наименование из вашего прайс-листа к номинальному наименования в системе.',
	75 => 'Укажите сколько максимум приемлемых секунд будет ожидать пользователь каталога пока сервер делает API запросы цен ваших активных Веб-сервисов. По достижению лимита запросы прервуться и пользователю покажутся те цены на список товаров которые успели быть запрошены. Если отключено - будет использоваться только AJAX метод API запросов в браузере посетителей',
);
?>