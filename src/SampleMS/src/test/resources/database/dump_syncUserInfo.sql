CREATE TABLE "tb_syncUserInfo"(
  "userId" INTEGER PRIMARY KEY NOT NULL,
  "displayName" VARCHAR(255) NOT NULL,
  "email" BOOLEAN NOT NULL DEFAULT 0,
  "emailNotification" VARCHAR(4) ,
  "pushNotification" VARCHAR(4) ,
  "smsNotification" VARCHAR(4) ,
  "revoked" BOOLEAN NOT NULL DEFAULT 0,
  "lastAccessOn" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP
);