CREATE TABLE "account_user" (
    "id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "email"  TEXT,
    "username"  TEXT,
    "password"  TEXT,
    "first_name"  TEXT,
    "last_name"  TEXT,
    "status" INTEGER
);
CREATE INDEX "account_user_email" ON "account_user" ("email");
CREATE INDEX "account_user_username" ON "account_user" ("username");
CREATE INDEX "account_user_first_name" ON "account_user" ("first_name");
CREATE INDEX "account_user_last_name" ON "account_user" ("last_name");

INSERT INTO "account_user" ('email', 'username', 'password', 'first_name', 'last_name', 'status') VALUES ('admin@localhost', 'admin', '$2a$08$b.5MVtbgKv4Dvf/M3AFKKuga4pxptFOsmu7gkN.QOH5yvws6Ks03i', 'admin', 'admin', 1);

CREATE TABLE "email_spool" (
    "id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "transport" TEXT,
    "template" TEXT,
    "priority" INTEGER,
    "status" TEXT,
    "model_name" TEXT,
    "model_id" TEXT,
    "to_address" TEXT,
    "from_address" TEXT,
    "subject" TEXT,
    "message" BLOB,
    "sent" INTEGER,
    "created" INTEGER
);
CREATE INDEX "email_spool_model" ON "email_spool" ("model_name","model_id");
CREATE INDEX "email_spool_transport" ON "email_spool" ("transport");
CREATE INDEX "email_spool_template" ON "email_spool" ("template");
CREATE INDEX "email_spool_status" ON "email_spool" ("status");
CREATE INDEX "email_spool_to_address" ON "email_spool" ("to_address");
CREATE INDEX "email_spool_from_address" ON "email_spool" ("from_address");
CREATE INDEX "email_spool_subject" ON "email_spool" ("subject");
CREATE INDEX "email_spool_sent" ON "email_spool" ("sent");
CREATE INDEX "email_spool_created" ON "email_spool" ("created");

CREATE TABLE "email_template" (
"id"  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"name" TEXT,
"subject" TEXT,
"heading" TEXT,
"message" TEXT
);
INSERT INTO "email_template" ('name', 'subject', 'heading', 'message') VALUES ('layout_default', '{{contents}}', '{{contents}}', '{{#heading}}<h1>{{{heading}}}</h1>{{/heading}}{{{contents}}}');
INSERT INTO "email_template" ('name', 'subject', 'heading', 'message') VALUES ('account_lost_password', 'Reset Your Password', 'Reset Your Password', '<a href="{{url}}">click here to reset your password</a>');
INSERT INTO "email_template" ('name', 'subject', 'heading', 'message') VALUES ('account_activate', 'Activate Your Account', 'Activate Your Account', '<a href="{{url}}">click here to activate your account</a>');
INSERT INTO "email_template" ('name', 'subject', 'heading', 'message') VALUES ('account_welcome', 'Welcome', 'Welcome', 'Welcome');