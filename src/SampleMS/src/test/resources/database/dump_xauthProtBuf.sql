CREATE TABLE "xauth_protocolBufferCached"(
  "id" INTEGER PRIMARY KEY NOT NULL,
  "clientApiName" VARCHAR(255) NOT NULL,
  "clientApiHashedKey" VARCHAR(255) NOT NULL,
  "userToken" VARCHAR(5000) ,
  "userInfoCached" VARCHAR(255),
  "expiresOn" TIMESTAMP,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP
);