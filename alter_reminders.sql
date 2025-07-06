-- Alter reminders table to add reminder_time (if not exists)
ALTER TABLE reminders ADD COLUMN reminder_time TIME AFTER reminder_date;

ALTER TABLE reminders ADD COLUMN username VARCHAR(50) AFTER id;
