CREATE TABLE "xauth_clients"(
  "name" VARCHAR(45) PRIMARY KEY NOT NULL,
  "secret" VARCHAR(255) NOT NULL,
  "require_user_token" INTEGER NOT NULL DEFAULT 0,
  "app_consumer" VARCHAR(45) ,
  "revoked" BOOLEAN NOT NULL DEFAULT 0,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP
);