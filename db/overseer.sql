--
-- PostgreSQL database dump
--


CREATE TABLE public.resetcodes (
    username text NOT NULL,
    resetcode integer NOT NULL,
    expiration_date timestamp without time zone,
    used boolean DEFAULT false
);



CREATE TABLE public.userdata (
    username text NOT NULL,
    email text,
    enabled boolean DEFAULT true
);



ALTER TABLE ONLY public.resetcodes
    ADD CONSTRAINT resetcodes_pkey PRIMARY KEY (username, resetcode);


ALTER TABLE ONLY public.userdata
    ADD CONSTRAINT userdata_pkey PRIMARY KEY (username);


ALTER TABLE ONLY public.resetcodes
    ADD CONSTRAINT fk_resetcodes_username FOREIGN KEY (username) REFERENCES public.userdata(username);

--
-- PostgreSQL database dump complete
--

