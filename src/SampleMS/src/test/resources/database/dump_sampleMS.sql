CREATE TABLE "tb_sample" (
  "id" INTEGER(11) NOT NULL PRIMARY KEY,
  "name" varchar(100) NOT NULL,
  "createdAt" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updatedAt" TIMESTAMP
);