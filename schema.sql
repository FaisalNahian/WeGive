-- Table: challenges

-- DROP TABLE challenges;

CREATE TABLE challenges
(
  id serial NOT NULL,
  user_id integer NOT NULL,
  charity_id integer NOT NULL,
  created_date timestamp without time zone NOT NULL DEFAULT now(),
  base_donation_pence integer NOT NULL,
  matching_percentage integer NOT NULL,
  matching_upper_limit_pence integer NOT NULL DEFAULT 500,
  end_date timestamp without time zone,
  CONSTRAINT challenges_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE challenges OWNER TO wegive;

-- Table: charities

-- DROP TABLE charities;

CREATE TABLE charities
(
  id serial NOT NULL,
  "name" text NOT NULL,
  description text,
  image_url text,
  missionfish_id text,
  CONSTRAINT charity_pkey PRIMARY KEY (id),
  CONSTRAINT charities_name_key UNIQUE (name)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE charities OWNER TO wegive;

-- Table: follows

-- DROP TABLE follows;

CREATE TABLE follows
(
  id serial NOT NULL,
  user_id integer NOT NULL,
  follower_id integer NOT NULL,
  CONSTRAINT follows_pkey PRIMARY KEY (id),
  CONSTRAINT follows_follower_id_fkey FOREIGN KEY (follower_id)
      REFERENCES users (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT follows_user_id_fkey FOREIGN KEY (user_id)
      REFERENCES users (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT follows_user_id_key UNIQUE (user_id, follower_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE follows OWNER TO wegive;



-- Table: users

-- DROP TABLE users;

CREATE TABLE users
(
  id serial NOT NULL,
  screen_name text,
  created_date timestamp without time zone NOT NULL DEFAULT now(),
  twitter_id bigint,
  profile_image_url text,
  last_login_date timestamp without time zone,
  twitter_oauth_token text,
  twitter_oauth_token_secret text,
  followers_last_updated_date timestamp without time zone,
  CONSTRAINT users_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE users OWNER TO wegive;
