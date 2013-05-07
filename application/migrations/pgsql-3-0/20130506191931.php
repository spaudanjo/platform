<?php defined('SYSPATH') OR die('No direct script access.');

class Migration_Pgsql_3_0_20130506191931 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database $db Database connection
	 */
	public function up(Kohana_Database $db)
	{
		$db->query(NULL, 'SET client_encoding = \'UTF8\';');
		$db->query(NULL, 'SET standard_conforming_strings = off;');
		$db->query(NULL, 'SET check_function_bodies = false;');
		$db->query(NULL, 'SET client_min_messages = warning;');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS form_attributes_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE form_attributes_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');

		$db->query(NULL, 'SELECT pg_catalog.setval(\'form_attributes_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "form_attributes" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "form_attributes" (
			"id" integer DEFAULT nextval(\'form_attributes_id_seq\'::regclass) NOT NULL,
			"key" character varying(150) DEFAULT \'\'::character varying NOT NULL,
			"label" character varying(150) DEFAULT \'\'::character varying NOT NULL,
			"input" character varying(30) DEFAULT \'text\'::character varying NOT NULL,
			"type" character varying(30) DEFAULT \'varchar\'::character varying NOT NULL,
			"required" boolean DEFAULT false NOT NULL,
			"default" character varying(255),
			"unique" boolean DEFAULT false NOT NULL,
			"priority" smallint DEFAULT 99 NOT NULL,
			"options" character varying(255),
			CONSTRAINT form_attributes_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "unq_key" CASCADE;');
		$db->query(NULL, 'CREATE UNIQUE INDEX "unq_key" ON "form_attributes" ("key");');

		$db->query(NULL, 'DROP SEQUENCE IF EXISTS form_groups_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE form_groups_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');

		$db->query(NULL, 'SELECT pg_catalog.setval(\'form_groups_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "form_groups" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "form_groups" (
			"id" integer DEFAULT nextval(\'form_groups_id_seq\'::regclass) NOT NULL,
			"form_id" bigint DEFAULT 0 NOT NULL,
			"label" character varying(150) DEFAULT \'\'::character varying NOT NULL,
			"priority" smallint DEFAULT 99 NOT NULL,
			CONSTRAINT form_groups_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_form_groups_form_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_form_groups_form_id" ON "form_groups" ("form_id");');

		$db->query(NULL, 'DROP TABLE IF EXISTS "form_groups_form_attributes" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "form_groups_form_attributes" (
			"form_group_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT form_groups_form_attributes_pkey PRIMARY KEY("form_group_id", "form_attribute_id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_form_groups_form_attributes_form_group_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_form_groups_form_attributes_form_group_id" ON "form_groups_form_attributes" ("form_group_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_form_groups_form_attributes_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_form_groups_form_attributes_form_attribute_id" ON "form_groups_form_attributes" ("form_attribute_id");');

		$db->query(NULL, 'DROP SEQUENCE IF EXISTS forms_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE forms_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');

		$db->query(NULL, 'SELECT pg_catalog.setval(\'forms_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "forms" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "forms" (
			"id" integer DEFAULT nextval(\'forms_id_seq\'::regclass) NOT NULL,
			"parent_id" bigint DEFAULT 0 NOT NULL,
			"name" character varying(255) DEFAULT \'\'::character varying NOT NULL,
			"description" text,
			"type" character varying(30) DEFAULT \'report\'::character varying NOT NULL,
			"created" bigint DEFAULT 0 NOT NULL,
			"updated" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT forms_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "idx_parent_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "idx_parent_id" ON "forms" ("parent_id");');

		
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_comments_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_comments_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_comments_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "post_comments" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_comments" (
			"id" integer DEFAULT nextval(\'post_comments_id_seq\'::regclass) NOT NULL,
			"parent_id" bigint,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"user_id" bigint,
			"content" text,
			"author" character varying(150),
			"email" character varying(150),
			"status" character varying(20) DEFAULT \'pending\'::character varying NOT NULL,
			"created" bigint DEFAULT 0 NOT NULL,
			"updated" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_comments_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_comments_parent_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_comments_parent_id" ON "post_comments" ("parent_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_comments_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_comments_post_id" ON "post_comments" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_comments_user_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_comments_user_id" ON "post_comments" ("user_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_datetime_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_datetime_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');

		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_datetime_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "post_datetime" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_datetime" (
			"id" integer DEFAULT nextval(\'post_datetime_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" timestamp without time zone,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_datetime_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_datetime_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_datetime_post_id" ON "post_datetime" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_datetime_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_datetime_form_attribute_id" ON "post_datetime" ("form_attribute_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_decimal_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_decimal_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_decimal_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "post_decimal" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_decimal" (
			"id" integer DEFAULT nextval(\'post_decimal_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" numeric(12, 4) DEFAULT 0.0000,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_decimal_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_decimal_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_decimal_post_id" ON "post_decimal" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_decimal_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_decimal_form_attribute_id" ON "post_decimal" ("form_attribute_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_geometry_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_geometry_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_geometry_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "post_geometry" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_geometry" (
			"id" integer DEFAULT nextval(\'post_geometry_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" text,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_geometry_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_geometry_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_geometry_post_id" ON "post_geometry" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_geometry_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_geometry_form_attribute_id" ON "post_geometry" ("form_attribute_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_int_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_int_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_int_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "post_int" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_int" (
			"id" integer DEFAULT nextval(\'post_int_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" integer DEFAULT 0,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_int_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_int_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_int_post_id" ON "post_int" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_int_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_int_form_attribute_id" ON "post_int" ("form_attribute_id");');

		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_point_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_point_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_point_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "post_point" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_point" (
			"id" integer DEFAULT nextval(\'post_point_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" integer,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_point_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_point_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_point_post_id" ON "post_point" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_point_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_point_form_attribute_id" ON "post_point" ("form_attribute_id");');

		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_text_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_text_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_text_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "post_text" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_text" (
			"id" integer DEFAULT nextval(\'post_text_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" text,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_text_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_text_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_text_post_id" ON "post_text" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_text_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_text_form_attribute_id" ON "post_text" ("form_attribute_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS post_varchar_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE post_varchar_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'post_varchar_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "post_varchar" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "post_varchar" (
			"id" integer DEFAULT nextval(\'post_varchar_id_seq\'::regclass) NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"form_attribute_id" bigint,
			"value" character varying(255),
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT post_varchar_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_varchar_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_varchar_post_id" ON "post_varchar" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_post_varchar_form_attribute_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_post_varchar_form_attribute_id" ON "post_varchar" ("form_attribute_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS posts_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE posts_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'posts_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "posts" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "posts" (
			"id" integer DEFAULT nextval(\'posts_id_seq\'::regclass) NOT NULL,
			"parent_id" bigint,
			"form_id" bigint,
			"user_id" bigint,
			"type" character varying(20) DEFAULT \'report\'::character varying NOT NULL,
			"title" character varying(150),
			"slug" character varying(150),
			"content" text,
			"author" character varying(150),
			"email" character varying(150),
			"status" character varying(20) DEFAULT \'draft\'::character varying NOT NULL,
			"created" bigint DEFAULT 0 NOT NULL,
			"updated" bigint DEFAULT 0 NOT NULL,
			"locale" character varying(5) DEFAULT \'en_us\'::character varying NOT NULL,
			CONSTRAINT posts_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "idx_type" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "idx_type" ON "posts" ("type");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "idx_status" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "idx_status" ON "posts" ("status");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_posts_parent_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_posts_parent_id" ON "posts" ("parent_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_posts_form_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_posts_form_id" ON "posts" ("form_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_posts_user_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_posts_user_id" ON "posts" ("user_id");');

		$db->query(NULL, 'DROP TABLE IF EXISTS "posts_sets" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "posts_sets" (
			"post_id" bigint DEFAULT 0 NOT NULL,
			"set_id" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT posts_sets_pkey PRIMARY KEY("post_id", "set_id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_posts_sets_set_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_posts_sets_set_id" ON "posts_sets" ("set_id");');

		$db->query(NULL, 'DROP TABLE IF EXISTS "posts_tags" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "posts_tags" (
			"post_id" bigint DEFAULT 0 NOT NULL,
			"tag_id" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT posts_tags_pkey PRIMARY KEY("post_id", "tag_id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_posts_tags_tag_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_posts_tags_tag_id" ON "posts_tags" ("tag_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS roles_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE roles_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'roles_id_seq\', 1, true);');

		$db->query(NULL, 'DROP TABLE IF EXISTS "roles" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "roles" (
			"id" integer DEFAULT nextval(\'roles_id_seq\'::regclass) NOT NULL,
			"name" character varying(32) NOT NULL,
			"description" character varying(255),
			"permissions" character varying(255),
			"user_id" integer,
			CONSTRAINT roles_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "name" CASCADE;');
		$db->query(NULL, 'CREATE UNIQUE INDEX "name" ON "roles" ("name");');

		$db->query(NULL, 'DROP TABLE IF EXISTS "roles_users" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "roles_users" (
			"user_id" bigint DEFAULT 0 NOT NULL,
			"role_id" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT roles_users_pkey PRIMARY KEY("user_id", "role_id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_roles_users_role_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_roles_users_role_id" ON "roles_users" ("role_id");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS sets_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE sets_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
			
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'sets_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "sets" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "sets" (
			"id" integer DEFAULT nextval(\'sets_id_seq\'::regclass) NOT NULL,
			"user_id" bigint DEFAULT 0 NOT NULL,
			"name" character varying(255) DEFAULT \'\'::character varying NOT NULL,
			"filter" text,
			"created" integer DEFAULT 0 NOT NULL,
			"updated" integer DEFAULT 0 NOT NULL,
			CONSTRAINT sets_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS tags_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE tags_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'tags_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "tags" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "tags" (
			"id" integer DEFAULT nextval(\'tags_id_seq\'::regclass) NOT NULL,
			"parent_id" bigint DEFAULT 0 NOT NULL,
			"tag" character varying(200) DEFAULT \'\'::character varying NOT NULL,
			"slug" character varying(200),
			"type" character varying(20),
			"priority" smallint DEFAULT 99 NOT NULL,
			"created" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT tags_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "idx_parent_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "idx_parent_id" ON "tags" ("parent_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "idx_tag" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "idx_tag" ON "tags" ("tag");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS tasks_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE tasks_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'tasks_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "tasks" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "tasks" (
			"id" integer DEFAULT nextval(\'tasks_id_seq\'::regclass) NOT NULL,
			"parent_id" bigint DEFAULT 0 NOT NULL,
			"post_id" bigint DEFAULT 0 NOT NULL,
			"assignee" bigint,
			"assignor" bigint,
			"description" character varying(255),
			"status" character varying(20) DEFAULT \'pending\'::character varying NOT NULL,
			"due" bigint DEFAULT 0 NOT NULL,
			"created" bigint DEFAULT 0 NOT NULL,
			"updated" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT tasks_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "idx_status" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "idx_status" ON "tasks" ("status");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_tasks_parent_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_tasks_parent_id" ON "tasks" ("parent_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_tasks_post_id" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_tasks_post_id" ON "tasks" ("post_id");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_tasks_assignee" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_tasks_assignee" ON "tasks" ("assignee");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "fk_tasks_assignor" CASCADE;');
		$db->query(NULL, 'CREATE INDEX "fk_tasks_assignor" ON "tasks" ("assignor");');
		 
		$db->query(NULL, 'DROP SEQUENCE IF EXISTS users_id_seq CASCADE;');
		 
		$db->query(NULL, 'CREATE SEQUENCE users_id_seq
			INCREMENT BY 1
			NO MAXVALUE
			NO MINVALUE
			CACHE 1;');
				
				
		$db->query(NULL, 'SELECT pg_catalog.setval(\'users_id_seq\', 1, true);');
		 
		$db->query(NULL, 'DROP TABLE IF EXISTS "users" CASCADE;');
		 
		$db->query(NULL, 'CREATE TABLE "users" (
			"id" integer DEFAULT nextval(\'users_id_seq\'::regclass) NOT NULL,
			"email" character varying(127) NOT NULL,
			"first_name" character varying(150),
			"last_name" character varying(150),
			"username" character varying(255) NOT NULL,
			"password" character varying(255) NOT NULL,
			"avatar" character varying(50),
			"logins" bigint DEFAULT 0 NOT NULL,
			"last_login" bigint,
			"created" bigint DEFAULT 0 NOT NULL,
			"updated" bigint DEFAULT 0 NOT NULL,
			CONSTRAINT users_pkey PRIMARY KEY("id")
		)
		WITHOUT OIDS;');
		$db->query(NULL, 'DROP INDEX IF EXISTS "unq_email" CASCADE;');
		$db->query(NULL, 'CREATE UNIQUE INDEX "unq_email" ON "users" ("email");');
		$db->query(NULL, 'DROP INDEX IF EXISTS "unq_username" CASCADE;');
		$db->query(NULL, 'CREATE UNIQUE INDEX "unq_username" ON "users" ("username");');


		$db->query(NULL, 'ALTER TABLE "form_groups" ADD FOREIGN KEY ("form_id") REFERENCES "forms"("id");');
		$db->query(NULL, 'ALTER TABLE "form_groups_form_attributes" ADD FOREIGN KEY ("form_group_id") REFERENCES "form_groups"("id");');
		$db->query(NULL, 'ALTER TABLE "form_groups_form_attributes" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_comments" ADD FOREIGN KEY ("parent_id") REFERENCES "post_comments"("id");');
		$db->query(NULL, 'ALTER TABLE "post_comments" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_comments" ADD FOREIGN KEY ("user_id") REFERENCES "users"("id");');
		$db->query(NULL, 'ALTER TABLE "post_datetime" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_datetime" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_decimal" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_decimal" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_geometry" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_geometry" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_int" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_int" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_point" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_point" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_text" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_text" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "post_varchar" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "post_varchar" ADD FOREIGN KEY ("form_attribute_id") REFERENCES "form_attributes"("id");');
		$db->query(NULL, 'ALTER TABLE "posts" ADD FOREIGN KEY ("parent_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "posts" ADD FOREIGN KEY ("form_id") REFERENCES "forms"("id");');
		$db->query(NULL, 'ALTER TABLE "posts" ADD FOREIGN KEY ("user_id") REFERENCES "users"("id");');
		$db->query(NULL, 'ALTER TABLE "posts_sets" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "posts_sets" ADD FOREIGN KEY ("set_id") REFERENCES "sets"("id");');
		$db->query(NULL, 'ALTER TABLE "posts_tags" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "posts_tags" ADD FOREIGN KEY ("tag_id") REFERENCES "tags"("id");');
		$db->query(NULL, 'ALTER TABLE "roles_users" ADD FOREIGN KEY ("role_id") REFERENCES "roles"("id");');
		$db->query(NULL, 'ALTER TABLE "roles_users" ADD FOREIGN KEY ("user_id") REFERENCES "users"("id");');
		$db->query(NULL, 'ALTER TABLE "tasks" ADD FOREIGN KEY ("parent_id") REFERENCES "tasks"("id");');
		$db->query(NULL, 'ALTER TABLE "tasks" ADD FOREIGN KEY ("post_id") REFERENCES "posts"("id");');
		$db->query(NULL, 'ALTER TABLE "tasks" ADD FOREIGN KEY ("assignee") REFERENCES "users"("id");');
		$db->query(NULL, 'ALTER TABLE "tasks" ADD FOREIGN KEY ("assignor") REFERENCES "users"("id");');

	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database $db Database connection
	 */
	public function down(Kohana_Database $db)
	{
		// $db->query(NULL, 'DROP TABLE ... ');
	}

}
