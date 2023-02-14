# Séléction de tous les champs de la table category
SELECT * FROM category;
# Séléction des champs id et title de la table category
SELECT id, title FROM category;
# Séléction des champs id et title de la table category classé par id ascendant
SELECT id, title FROM category ORDER BY id ASC;
# Séléction des champs id (renommé en idcateg) et title (renommé en titlecateg) de la table category classé par id ascendant
SELECT id AS idcateg, title as titlecateg FROM category ORDER BY id ASC;


# Séléction de tous les champs de la table post
SELECT * FROM post;
# Séléction des champs id, title et datecreate de la table post
SELECT id, title, datecreate FROM post;
# Séléction des champs id, title et datecreate de la table post ordonnés par datecreate descendante
SELECT id, title, datecreate FROM post ORDER BY datecreate DESC;
# Séléction des champs id (renommé en idpost), title (renommé en titlepost) et datecreate de la table post ordonnés par datecreate descendante
SELECT id AS idpost, title AS titlepost, datecreate FROM post ORDER BY datecreate DESC;

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post ordonnés par datecreate descendante
SELECT id AS idpost, title AS titlepost, LEFT(content,255) AS contentshort, datecreate FROM post ORDER BY datecreate DESC;

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post quand visible vaut 1 ordonnés par datecreate descendante
SELECT id AS idpost, title AS titlepost, LEFT(content,255) AS contentshort, datecreate 
FROM post 
WHERE visible = 1 
ORDER BY datecreate DESC;

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post quand user_id n'est pas NULL (voir commande SQL: isnull())  ordonnés par datecreate descendante
SELECT 
    id AS idpost,
    title AS titlepost,
    LEFT(content, 255) AS contentshort,
    datecreate
FROM
    post
WHERE
    user_id IS NOT NULL
ORDER BY datecreate DESC;

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post quand user_id n'est pas NULL (voir commande SQL: isnull()) ET que visible vaut 1 ordonnés par datecreate descendante
SELECT 
    id AS idpost,
    title AS titlepost,
    LEFT(content, 255) AS contentshort,
    datecreate
FROM
    post
WHERE
    user_id IS NOT NULL AND visible=1
ORDER BY datecreate DESC;


# Séléction de tous les champs de la table user
SELECT * FROM user;
# Séléction des champs id, username, userscreen de la table user classés par userscreen ascendant
SELECT id, username, userscreen FROM user ORDER BY userscreen ASC;
# Séléction des champs id, username, userscreen de la table user quand actif vaut 1 classés par userscreen ascendant
SELECT id, username, userscreen FROM user WHERE actif=1 ORDER BY userscreen ASC;

#
# JOINTURES INTERNES [INNER] - INNER JOIN ou JOIN
# https://sql.sh/cours/jointures
#

# Séléction des champs id, title et datecreate de la table post, AVEC le usercreen de la table user SEULEMENT si le lien existe, ordonnés par datecreate ascendante
# Il faut utiliser le nom des tables pour éviter qu'il y ai une collision d'id !
SELECT post.id, post.title, post.datecreate, user.userscreen 
FROM post
INNER JOIN user
	ON user.id = post.user_id
    ORDER BY post.datecreate ASC;


# idem avec alias internes (alias de tables)
SELECT p.id, p.title, p.datecreate, u.userscreen 
FROM post p
INNER JOIN user u
	ON u.id = p.user_id
    ORDER BY p.datecreate ASC;

#
# JOINTURES EXTERNES [OUTER] - LEFT ou RIGHT JOIN
#

# Séléction des champs id, title et datecreate de la table post, AVEC le usercreen de la table user MEME  si le lien N'EXISTE PAS (tous les post), ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, u.userscreen 
FROM post p
	LEFT JOIN user u
		ON p.user_id = u.id
ORDER BY p.datecreate ASC;



# Séléction des champs id, title et datecreate de la table post, AVEC le usercreen de la table user DANS TOUS LES CAS même si le lien N'EXISTE PAS (tous les user), ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, u.userscreen 
FROM post p
	RIGHT JOIN user u
		ON p.user_id = u.id
ORDER BY p.datecreate ASC;

#
# JOINTURES sur M2M (many to many)
#

# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category SEULEMENT si le lien existe (que les données en INNER), ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, c.id AS idcategory, c.title AS titlecategory
FROM post p
	INNER JOIN category_has_post h 
    ON p.id = h.post_id
    INNER JOIN category c 
    ON c.id = h.category_id
ORDER BY p.datecreate ASC;

# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category MEME si le lien N'EXISTE PAS (tous les post), ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, c.id AS idcategory, c.title AS titlecategory
FROM post p
	LEFT JOIN category_has_post h 
    ON p.id = h.post_id
    LEFT JOIN category c 
    ON c.id = h.category_id
    
ORDER BY p.datecreate ASC;

# idem que le précédent pour trouver QUE les post qui n'ont PAS de category (sans les champs de category à l'affichage, voir isnull()), en partant de FROM post !
SELECT p.id, p.title, p.datecreate, c.id AS idcategory, c.title AS titlecategory
FROM post p
	LEFT JOIN category_has_post h 
    ON p.id = h.post_id
    LEFT JOIN category c 
    ON c.id = h.category_id
    WHERE c.id IS NULL
ORDER BY p.datecreate ASC;

# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category DANS TOUS LES CAS même si le lien N'EXISTE PAS (toutes les category) ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, c.id AS idcategory, c.title AS titlecategory
FROM post p
	RIGHT JOIN category_has_post h 
    ON p.id = h.post_id
    RIGHT JOIN category c 
    ON c.id = h.category_id
ORDER BY p.datecreate ASC;


# idem que le précédent pour trouver QUE les category qui n'ont PAS de post (sans les champs de post à l'affichage, voir isnull()), en partant de FROM post !
SELECT c.id AS idcategory, c.title AS titlecategory
FROM post p
	RIGHT JOIN category_has_post h 
    ON p.id = h.post_id
    RIGHT JOIN category c
    ON c.id = h.category_id
    WHERE p.id IS NULL
ORDER BY p.datecreate ASC;


#
# JOINTURES M2M + one to many (1 ou plusieures o2m)
# !!! 2 jointures many to many pourront mener à des comportements inattendus! A éviter
#

# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user SEULEMENT si le lien existe (que les données en INNER), AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category SEULEMENT si le lien existe (que les données en INNER), ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, u.id AS iduser, u.userscreen, c.id AS idcategory, c.title AS titlecategory
FROM post p
	INNER JOIN user u
		ON p.user_id = u.id
	INNER JOIN category_has_post h 
		ON p.id = h.post_id
    INNER JOIN category c 
		ON c.id = h.category_id
ORDER BY p.datecreate ASC;


# Le many to many permet d'avoir des doublons, pour éviter cela, on peut utiliser GROUP BY (sur post) et GROUP_CONCAT (sur les champs de category) (en mysql er mariadb)
# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user SEULEMENT si le lien existe (que les données en INNER), AVEC l'id concaténé avec la , (renommé en idcategory) et title concaténé avec '||0||' (renommé en titlecategory) de la table category SEULEMENT si le lien existe (que les données en INNER), ordonnés par datecreate ascendante groupé par la clef primaire de post
SELECT p.id, p.title, p.datecreate, u.id AS iduser, u.userscreen, 
GROUP_CONCAT(c.id) AS idcategory, 
GROUP_CONCAT(c.title SEPARATOR '||0||') AS titlecategory
FROM post p
	INNER JOIN user u
		ON p.user_id = u.id
	INNER JOIN category_has_post h 
		ON p.id = h.post_id
    INNER JOIN category c 
		ON c.id = h.category_id
        GROUP BY p.id
ORDER BY p.datecreate ASC;


# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user AUSSI si le lien existe (que les données en LEFT, tous les articles), AVEC l'id concaténé avec la , (renommé en idcategory) et title concaténé avec '||0||' (renommé en titlecategory) de la table category AUSSI si le lien existe (tous les articles), ordonnés par datecreate ascendante
SELECT p.id, p.title, p.datecreate, u.id AS iduser, u.userscreen, 
GROUP_CONCAT(c.id) AS idcategory, 
GROUP_CONCAT(c.title SEPARATOR '||0||') AS titlecategory
FROM post p
	LEFT JOIN user u
		ON p.user_id = u.id
	LEFT JOIN category_has_post h 
		ON p.id = h.post_id
    LEFT JOIN category c 
		ON c.id = h.category_id
        GROUP BY p.id
ORDER BY p.datecreate ASC;

# Séléction des champs id, title, 255 caractères de content (renommé en contentshort) et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user SEULEMENT si le lien existe (INNER), AVEC l'id concaténé avec la , (renommé en idcategory) et title concaténé avec '||0||' (renommé en titlecategory) de la table category AUSSI si le lien existe (tous les articles), ordonnés par datecreate ascendante
SELECT p.id, p.title, LEFT(p.content, 255) AS contentshort, p.datecreate, u.id AS iduser, u.userscreen, 
GROUP_CONCAT(c.id) AS idcategory, 
GROUP_CONCAT(c.title SEPARATOR '||0||') AS titlecategory
FROM post p
	INNER JOIN user u
		ON p.user_id = u.id
	LEFT JOIN category_has_post h 
		ON p.id = h.post_id
    LEFT JOIN category c 
		ON c.id = h.category_id
        GROUP BY p.id
ORDER BY p.datecreate ASC;