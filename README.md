# API каталог машин

- [1. Развернуть проект](#1-развернуть-проект)
- [2. Маршруты](#2-маршруты)
  - [2.1. Cars](#21-cars)
  - [2.2. Car](#22-car)
  - [2.3. Credit Program](#23-credit-program)
  - [2.4. Application](#24-application)
- [3. Компоненты](#3-компоненты)

## 1. Развернуть проект

Composer:
```bash
docker compose up --build
```

Миграции:
```bash
docker compose exec app symfony console doctrine:migrations:migrate
```

Если нужно заполнить БД тестовыми данными:
```bash
docker compose exec app symfony console doctrine:fixtures:load
```

| Программа       | Условия                                                                                    | Описание      |
|-----------------|--------------------------------------------------------------------------------------------|---------------|
| Expensive Car   | Цена автомобился больше 2 000 000                                                          | - процент 15% |
| Initial Payment | Первоначальный взнос > 30% от стоимости машины Срок кредита е превышает 5 лет (60 месяцев) | - процент 11% |
| Standart        | Для любых других случаев                                                                   | - процент 13% |

## 2. Маршруты
Обязательный заголовок: `Accept: application/json`

> Документация, веб-интерфейс: `/api/doc`  
> Документация в формате .json: `/api/doc.json`

### 2.1. Cars
- **URL**: GET /api/v1/cars
- **Query Parameters**: 
  - page: integer, nullable
- **Success**:
```json
{
    "data": [
        {
            "id": 1,
            "brand": {
                "id": 4,
                "name": "Mercedes-Benz"
            },
            "price": 3621095,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 2,
            "brand": {
                "id": 4,
                "name": "Mercedes-Benz"
            },
            "price": 4201865,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 3,
            "brand": {
                "id": 2,
                "name": "Honda"
            },
            "price": 3502349,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 4,
            "brand": {
                "id": 2,
                "name": "Honda"
            },
            "price": 991874,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 5,
            "brand": {
                "id": 3,
                "name": "Toyota"
            },
            "price": 1614027,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 6,
            "brand": {
                "id": 4,
                "name": "Mercedes-Benz"
            },
            "price": 4900353,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 7,
            "brand": {
                "id": 3,
                "name": "Toyota"
            },
            "price": 2525232,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 8,
            "brand": {
                "id": 1,
                "name": "BMW"
            },
            "price": 4873706,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 9,
            "brand": {
                "id": 3,
                "name": "Toyota"
            },
            "price": 1944112,
            "photo": "https://placehold.co/600x400.png"
        },
        {
            "id": 10,
            "brand": {
                "id": 1,
                "name": "BMW"
            },
            "price": 3356964,
            "photo": "https://placehold.co/600x400.png"
        }
    ],
    "pagination": {
        "currentPage": 1,
        "totalPages": 2,
        "perPage": 10,
        "total": 20
    }
}
```
- **Failed (page is string)**
400 Bad Request
```json
{
    "type": "https://tools.ietf.org/html/rfc2616#section-10",
    "title": "An error occurred",
    "status": 400,
    "detail": "Bad Request"
}
```

### 2.2. Car
- **URL**: GET /api/v1/car/{id}
- **Parameters**: car.id
- **Success**:
```json
{
    "data": {
        "id": 15,
        "price": 3480099,
        "photo": "https://placehold.co/600x400.png",
        "brand": {
            "id": 4,
            "name": "Mercedes-Benz"
        },
        "model": {
            "id": 1,
            "name": "Duster"
        }
    }
}
```
- **Failed (car not exists)**
  404 Not Found
```json
{
    "type": "https://tools.ietf.org/html/rfc2616#section-10",
    "title": "An error occurred",
    "status": 404,
    "detail": "Not Found"
}
```

### 2.3. Credit Program
- **URL**: GET /api/v1/credit/calculate
- **Query Parameters**: price, initialPayment, oanTerm
- **Success**:
```json
{
  "id": 3,
  "interestRate": 13,
  "monthlyPayment": 8084,
  "title": "Standard"
}
```
- **Failed (validation error)**
  400 Bad Request
```json
{
  "type": "https://symfony.com/errors/validation",
  "title": "Validation Failed",
  "status": 400,
  "detail": "initialPayment: The initial payment cannot exceed the price.\nloanTerm: Loan term must be less than or equal to 120",
  "violations": [
    {
      "propertyPath": "initialPayment",
      "title": "The initial payment cannot exceed the price.",
      "template": "The initial payment cannot exceed the price.",
      "parameters": []
    },
    {
      "propertyPath": "loanTerm",
      "title": "Loan term must be less than or equal to 120",
      "template": "Loan term must be less than or equal to 120",
      "parameters": {
        "{{ value }}": "3600",
        "{{ compared_value }}": "120",
        "{{ compared_value_type }}": "int"
      },
      "type": "urn:uuid:30fbb013-d015-4232-8b3b-8f3be97a7e14"
    }
  ]
}
```

### 2.4. Application
- **URL**: POST /api/v1/request
- **Query Parameters**: price, initialPayment, oanTerm
- **Success**:
```json
{
  "success": true
}
```
- **Failed (validation error)**
  400 Bad Request
```json
{
  "type": "https://symfony.com/errors/validation",
  "title": "Validation Failed",
  "status": 400,
  "detail": "initialPayment.initialPayment: The initial payment cannot exceed the price of the car.",
  "violations": [
    {
      "propertyPath": "initialPayment.initialPayment",
      "title": "The initial payment cannot exceed the price of the car.",
      "template": "The initial payment cannot exceed the price of the car.",
      "parameters": []
    }
  ]
}
```

## 3. Компоненты

- Контроллеры
  - ApplicationController (сохранение заявки на кредит)
  - CarController (получение списка машины и конкретной машины)
  - CreditProgramController (получение кредитной программы по условиям)
- Data Fixtures (заполнение тестовых данных)
- Dto (для описания структуры ответов)
  - BrandDto (содержание бренда, используется в запросах `/cars` и `/car`)
  - CarDto (один элемент из коллекции автомобилей для запроса `/cars`)
  - CartWithModel (запрос конкретной машины `/car`)
  - ModelDto (данные о модели машины)
  - PaginationDto (пагинация для запроса `/cars`)
- Request
  - ApplicationRequest (валидация входящих параметров запроса на создание заявки)
  - CalculateCreditProgramRequest (валидация запроса на подбор кредитной программы)
- Service
  - ApplicationService (сохранение заявки. цена берётся от машины)
  - CarDtoService/PaginationDtoService (формирование Dto)
  - CreditCalculatorService (подбор кредитной программы)
  - MonthlyPaymentCalculatorService (расчет ежемесячного платежа, используется при подборе кредитной программы и сохранения заявок)
- Validator
  - CarInitialPaymentValidator (проверяет, что при создании заявки первоначальный платёж не превышает цену автомобиля)
  - EntityExistsValidator (проверка существования сущности по id (при создании заявки проверяет carId и creditProgramId))