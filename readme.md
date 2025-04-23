# Crypto Portfolio API

API service for managing and tracking cryptocurrency portfolio, built on Laravel, with CoinGecko integration for obtaining up-to-date cryptocurrency market data.

## Key Features

- **Cryptocurrency Portfolio Management**: create, view, update, and delete cryptocurrency data in your portfolio
- **CoinGecko API Integration**: obtain real-time price and market information
- **Redis Caching**: performance optimization and reduction of external API requests
- **RESTful API**: full-featured API with Swagger documentation
- **Docker**: easy deployment using containers
- **Testing**: comprehensive unit test coverage

## Project Setup

To run the project, follow these steps:

1. **Clone the repository:**
```bash
git clone https://github.com/IliyaShevolaev/crypto-portfolio-api.git
```

2. **Copy the environment file and configure variables (enter API key):**
```bash
cp .env.example .env
```

3. **Run Docker Compose:**
```bash
docker-compose up -d
```

4. **Install Laravel dependencies:**
```bash
docker-compose run --rm composer install
```

5. **Generate application key:**
```bash
docker-compose run --rm artisan key:generate
```

6. **Run database migrations:**
```bash
docker-compose run --rm artisan migrate
```

## API Documentation
After installation, you can view the API documentation:

1.Find the API documentation JSON file at src/storage/api-docs/api-docs.json
2.Go to swagger.editor.io
3.Paste the JSON content to view the complete API documentation

# Crypto Portfolio API

API сервис для управления и отслеживания криптовалютного портфеля, построенный на Laravel, с интеграцией с CoinGecko для получения актуальных данных о рынке криптовалют.

## Основные особенности

- **Управление портфелем криптовалют**: создание, просмотр, обновление и удаление данных о криптовалютах в вашем портфеле
- **Интеграция с CoinGecko API**: получение актуальных данных о ценах и рыночной информации
- **Кеширование с использованием Redis**: оптимизация производительности и снижение числа запросов к внешним API
- **RESTful API**: полноценный API с документацией Swagger
- **Docker**: простое развертывание с использованием контейнеров
- **Тестирование**: комплексное покрытие юнит-тестами

## Запуск проекта

Для запуска проекта выполните следующие шаги:

1. **Клонируйте репозиторий:**
```bash
git clone https://github.com/IliyaShevolaev/crypto-portfolio-api.git
```

2. **Скопируйте файл окружения и настройте переменные(введите API ключ):**
```bash
cp .env.example .env
```

3. **Запустите Docker Compose:**
```bash
docker-compose up -d
```

4. **Установите зависимости Laravel:**
```bash
docker-compose run --rm composer install
```

5. **Сгенерируйте ключ приложения:**
```bash
docker-compose run --rm artisan key:generate
```

6. **Выполните миграции базы данных:**
```bash
docker-compose run --rm artisan migrate
```

## Документация API

После установки вы можете просмотреть документацию API:

1. Найдите JSON-файл документации API по пути `src/storage/api-docs/api-docs.json`
2. Перейдите на сайт [swagger.editor.io](https://swagger.editor.io)
3. Вставьте содержимое JSON-файла, чтобы просмотреть полную документацию API