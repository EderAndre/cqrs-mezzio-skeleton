CREATE TABLE "tb_syncUserInfo"(
  "userId" INTEGER PRIMARY KEY NOT NULL,
  "displayName" VARCHAR(510) NULL,
  "email" VARCHAR(510) NULL,
  "emailNotification" VARCHAR(4) NULL,
   "pushNotification" VARCHAR(4) NULL,
   "smsNotification" VARCHAR(4) NULL,
  "lastAccessOn" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP
);