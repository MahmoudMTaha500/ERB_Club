# نظام Saga Pattern للمعاملات الموزعة (Distributed Transactions)

## المشكلة
في الأنظمة الموزعة (Microservices)، لا يمكن استخدام `DB::transaction()` التقليدية لضمان atomicity عبر خدمات متعددة بقواعد بيانات مختلفة.

## الحل: Saga Pattern
تم تطوير نظام Saga Pattern لضمان:
- **Atomicity**: العملية تتم بالكامل أو تفشل بالكامل
- **Consistency**: البيانات تبقى متسقة عبر جميع الخدمات
- **Compensation**: التراجع التلقائي عند حدوث فشل

## معمارية النظام

### الخدمات المطلوبة:
1. **Inventory Service**: إدارة المخزون
2. **Orders Service**: إدارة الطلبات  
3. **Payments Service**: إدارة الدفعات

### مكونات النظام:
- `SagaOrchestrator`: منسق العملية الرئيسي
- `OrderOrchestrator`: منسق عملية الطلب
- `Compensation Actions`: إجراءات التراجع
- `Event System`: نظام الأحداث للتواصل

## تسلسل العملية

### العملية الناجحة:
1. **Reserve Inventory** - حجز المخزون
2. **Create Order** - إنشاء الطلب
3. **Process Payment** - معالجة الدفع
4. **Commit Inventory** - تأكيد المخزون
5. **Confirm Order** - تأكيد الطلب

### في حالة الفشل:
- يتم تنفيذ Compensation Actions بالترتيب العكسي
- إعادة المخزون المحجوز
- إلغاء الطلب
- رد الدفعة

## الملفات الرئيسية

### Core Saga Components:
- `app/Services/Saga/SagaOrchestrator.php`
- `app/Services/OrderOrchestrator.php`

### Services:
- `app/Services/InventoryService.php`
- `app/Services/OrdersService.php`  
- `app/Services/PaymentsService.php`

### Models:
- `app/Models/Product.php`
- `app/Models/Order.php`
- `app/Models/Payment.php`
- `app/Models/InventoryReservation.php`

### Events & Listeners:
- `app/Events/OrderProcessing*.php`
- `app/Listeners/OrderProcessingListener.php`

## كيفية الاستخدام

### 1. إعداد البيانات التجريبية:
```bash
POST /api/demo/setup
```

### 2. تجربة عملية ناجحة:
```bash
POST /api/demo/successful-order
```

### 3. تجربة عملية فاشلة:
```bash
POST /api/demo/failed-order
```

### 4. عرض حالة النظام:
```bash
GET /api/demo/status
```

## مثال على الاستخدام البرمجي:

```php
$orderOrchestrator = app(OrderOrchestrator::class);

$result = $orderOrchestrator->processOrder([
    'product_id' => 1,
    'quantity' => 2,
    'user_id' => 1,
    'amount' => 200.00,
    'payment_method' => 'credit_card'
]);

if ($result['success']) {
    echo "Order processed successfully!";
    echo "Order ID: " . $result['data']['order_id'];
} else {
    echo "Order failed, all changes rolled back";
}
```

## المزايا

### 1. Atomicity المضمونة:
- العملية تتم بالكامل أو تفشل بالكامل
- لا توجد حالات جزئية

### 2. Fault Tolerance:
- التعامل مع فشل أي خدمة
- التراجع التلقائي

### 3. Scalability:
- يعمل مع خدمات موزعة
- قابل للتوسع

### 4. Monitoring:
- تتبع كل خطوة
- Events للمراقبة

## الاختبار

### تشغيل الاختبارات:
```bash
php artisan test tests/Feature/SagaOrderProcessingTest.php
```

### تنظيف الحجوزات المنتهية الصلاحية:
```bash
php artisan inventory:cleanup-expired
```

## المراقبة والسجلات

النظام يسجل جميع الخطوات في Laravel logs:
- بداية ونهاية كل saga
- نجاح/فشل كل خطوة
- تنفيذ compensation actions

## ملاحظات مهمة

1. **Timeout**: الحجوزات تنتهي صلاحيتها خلال 15 دقيقة
2. **Idempotency**: جميع العمليات قابلة للتكرار بأمان
3. **Consistency**: eventual consistency عبر الخدمات
4. **Performance**: العملية قد تستغرق وقتاً أطول من transaction واحدة

## التطوير المستقبلي

- إضافة Saga State persistence
- تحسين Error handling
- إضافة Retry mechanisms
- تطوير Dashboard للمراقبة