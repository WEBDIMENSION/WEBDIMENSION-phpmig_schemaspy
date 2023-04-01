# Postgres

## login

```bash
docker-compose exec postgres psql -U postgres -d ec
```

## DB 一覧

```bash
\l
```

## table 一覧

```bash
\d
```

## Backup

```bash
#pg_dump -U USER_NAME -d DB_NAME > OUTPUT_FILE_NAMEバックアップファイル名
pg_dump -U postgres -d ec > /postgres_backup/backup.sql
```
