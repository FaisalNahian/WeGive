
SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 1811 (class 1262 OID 16385)
-- Name: wegive; Type: DATABASE; Schema: -; Owner: wegive
--

CREATE DATABASE wegive WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';

ALTER DATABASE wegive OWNER TO wegive;

\connect wegive

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1510 (class 1259 OID 16454)
-- Dependencies: 1793 1794 3
-- Name: challenges; Type: TABLE; Schema: public; Owner: wegive; Tablespace: 
--

CREATE TABLE challenges (
    id integer NOT NULL,
    user_id integer NOT NULL,
    charity_id integer NOT NULL,
    created_date timestamp without time zone DEFAULT now() NOT NULL,
    base_donation_pence integer NOT NULL,
    matching_percentage integer NOT NULL,
    matching_upper_limit_pence integer DEFAULT 500 NOT NULL,
    end_date timestamp without time zone,
    paypal_preapproval_key text,
    paypal_sender_email_address text
);


ALTER TABLE public.challenges OWNER TO wegive;

--
-- TOC entry 1509 (class 1259 OID 16452)
-- Dependencies: 3 1510
-- Name: challenges_id_seq; Type: SEQUENCE; Schema: public; Owner: wegive
--

CREATE SEQUENCE challenges_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.challenges_id_seq OWNER TO wegive;

--
-- TOC entry 1814 (class 0 OID 0)
-- Dependencies: 1509
-- Name: challenges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wegive
--

ALTER SEQUENCE challenges_id_seq OWNED BY challenges.id;


--
-- TOC entry 1506 (class 1259 OID 16413)
-- Dependencies: 3
-- Name: charities; Type: TABLE; Schema: public; Owner: wegive; Tablespace: 
--

CREATE TABLE charities (
    id integer NOT NULL,
    name text NOT NULL,
    description text,
    image_url text,
    missionfish_id text
);


ALTER TABLE public.charities OWNER TO wegive;

--
-- TOC entry 1505 (class 1259 OID 16411)
-- Dependencies: 3 1506
-- Name: charities_id_seq; Type: SEQUENCE; Schema: public; Owner: wegive
--

CREATE SEQUENCE charities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.charities_id_seq OWNER TO wegive;

--
-- TOC entry 1815 (class 0 OID 0)
-- Dependencies: 1505
-- Name: charities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wegive
--

ALTER SEQUENCE charities_id_seq OWNED BY charities.id;


--
-- TOC entry 1508 (class 1259 OID 16434)
-- Dependencies: 3
-- Name: follows; Type: TABLE; Schema: public; Owner: wegive; Tablespace: 
--

CREATE TABLE follows (
    id integer NOT NULL, -- this is stupid, but I haven't got time to fight/bypass ORM
    user_id integer NOT NULL,
    follower_id integer NOT NULL
);


ALTER TABLE public.follows OWNER TO wegive;

--
-- TOC entry 1507 (class 1259 OID 16432)
-- Dependencies: 3 1508
-- Name: follows_id_seq; Type: SEQUENCE; Schema: public; Owner: wegive
--

CREATE SEQUENCE follows_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.follows_id_seq OWNER TO wegive;

--
-- TOC entry 1816 (class 0 OID 0)
-- Dependencies: 1507
-- Name: follows_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wegive
--

ALTER SEQUENCE follows_id_seq OWNED BY follows.id;


--
-- TOC entry 1504 (class 1259 OID 16388)
-- Dependencies: 1789 3
-- Name: users; Type: TABLE; Schema: public; Owner: wegive; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    created_date timestamp without time zone DEFAULT now() NOT NULL,
    twitter_id bigint,
    screen_name text,
    description text,
    profile_image_url text,
    last_login_date timestamp without time zone,
    twitter_oauth_token text,
    twitter_oauth_token_secret text,
    followers_last_updated_date timestamp without time zone
);


ALTER TABLE public.users OWNER TO wegive;

--
-- TOC entry 1503 (class 1259 OID 16386)
-- Dependencies: 3 1504
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: wegive
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO wegive;

--
-- TOC entry 1817 (class 0 OID 0)
-- Dependencies: 1503
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: wegive
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1792 (class 2604 OID 16457)
-- Dependencies: 1510 1509 1510
-- Name: id; Type: DEFAULT; Schema: public; Owner: wegive
--

ALTER TABLE challenges ALTER COLUMN id SET DEFAULT nextval('challenges_id_seq'::regclass);


--
-- TOC entry 1790 (class 2604 OID 16416)
-- Dependencies: 1505 1506 1506
-- Name: id; Type: DEFAULT; Schema: public; Owner: wegive
--

ALTER TABLE charities ALTER COLUMN id SET DEFAULT nextval('charities_id_seq'::regclass);


--
-- TOC entry 1791 (class 2604 OID 16437)
-- Dependencies: 1508 1507 1508
-- Name: id; Type: DEFAULT; Schema: public; Owner: wegive
--

ALTER TABLE follows ALTER COLUMN id SET DEFAULT nextval('follows_id_seq'::regclass);


--
-- TOC entry 1788 (class 2604 OID 16391)
-- Dependencies: 1504 1503 1504
-- Name: id; Type: DEFAULT; Schema: public; Owner: wegive
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 1806 (class 2606 OID 16461)
-- Dependencies: 1510 1510
-- Name: challenges_pkey; Type: CONSTRAINT; Schema: public; Owner: wegive; Tablespace: 
--

ALTER TABLE ONLY challenges
    ADD CONSTRAINT challenges_pkey PRIMARY KEY (id);


--
-- TOC entry 1798 (class 2606 OID 16425)
-- Dependencies: 1506 1506
-- Name: charities_name_key; Type: CONSTRAINT; Schema: public; Owner: wegive; Tablespace: 
--

ALTER TABLE ONLY charities
    ADD CONSTRAINT charities_name_key UNIQUE (name);


--
-- TOC entry 1800 (class 2606 OID 16421)
-- Dependencies: 1506 1506
-- Name: charity_pkey; Type: CONSTRAINT; Schema: public; Owner: wegive; Tablespace: 
--

ALTER TABLE ONLY charities
    ADD CONSTRAINT charity_pkey PRIMARY KEY (id);


--
-- TOC entry 1802 (class 2606 OID 16439)
-- Dependencies: 1508 1508
-- Name: follows_pkey; Type: CONSTRAINT; Schema: public; Owner: wegive; Tablespace: 
--

ALTER TABLE ONLY follows
    ADD CONSTRAINT follows_pkey PRIMARY KEY (id);


--
-- TOC entry 1804 (class 2606 OID 16451)
-- Dependencies: 1508 1508 1508
-- Name: follows_user_id_key; Type: CONSTRAINT; Schema: public; Owner: wegive; Tablespace: 
--

ALTER TABLE ONLY follows
    ADD CONSTRAINT follows_user_id_key UNIQUE (user_id, follower_id);


--
-- TOC entry 1796 (class 2606 OID 16397)
-- Dependencies: 1504 1504
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: wegive; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 1808 (class 2606 OID 16445)
-- Dependencies: 1795 1504 1508
-- Name: follows_follower_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wegive
--

ALTER TABLE ONLY follows
    ADD CONSTRAINT follows_follower_id_fkey FOREIGN KEY (follower_id) REFERENCES users(id);


--
-- TOC entry 1807 (class 2606 OID 16440)
-- Dependencies: 1504 1795 1508
-- Name: follows_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: wegive
--

ALTER TABLE ONLY follows
    ADD CONSTRAINT follows_user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id);
