# Séléction de tous les champs de la table category
SELECT * FROM category;
# Séléction des champs id et title de la table category

# Séléction des champs id et title de la table category classé par id ascendant

# Séléction des champs id (renommé en idcateg) et title (renommé en titlecateg) de la table category classé par id ascendant



# Séléction de tous les champs de la table post
SELECT * FROM post;
# Séléction des champs id, title et datecreate de la table post

# Séléction des champs id, title et datecreate de la table post ordonnés par datecreate descendante

# Séléction des champs id (renommé en idpost), title (renommé en titlepost) et datecreate de la table post ordonnés par datecreate descendante

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post ordonnés par datecreate descendante

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post quand visible vaut 1 ordonnés par datecreate descendante

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post quand user_id n'est pas NULL (voir commande SQL: isnull())  ordonnés par datecreate descendante

# Séléction des champs id (renommé en idpost), title (renommé en titlepost), 255 caractères de content (renommé en contentshort) et datecreate de la table post quand user_id n'est pas NULL (voir commande SQL: isnull()) ET que visible vaut 1 ordonnés par datecreate descendante


# Séléction de tous les champs de la table user
SELECT * FROM user;
# Séléction des champs id, username, userscreen de la table user classés par userscreen ascendant

# Séléction des champs id, username, userscreen de la table user quand actif vaut 1 classés par userscreen ascendant


#
# JOINTURES INTERNES [INNER] - INNER JOIN ou JOIN
# https://sql.sh/cours/jointures
#

# Séléction des champs id, title et datecreate de la table post, AVEC le usercreen de la table user SEULEMENT si le lien existe, ordonnés par datecreate ascendante
# Il faut utiliser le nom des tables pour éviter qu'il y ai une collision d'id !


# idem avec alias internes (alias de tables)


#
# JOINTURES EXTERNES [OUTER] - LEFT ou RIGHT JOIN
#

# Séléction des champs id, title et datecreate de la table post, AVEC le usercreen de la table user MEME  si le lien N'EXISTE PAS (tous les post), ordonnés par datecreate ascendante


# Séléction des champs id, title et datecreate de la table post, AVEC le usercreen de la table user DANS TOUS LES CAS même si le lien N'EXISTE PAS (tous les user), ordonnés par datecreate ascendante


#
# JOINTURES sur M2M (many to many)
#

# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category SEULEMENT si le lien existe (que les données en INNER), ordonnés par datecreate ascendante


# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category MEME si le lien N'EXISTE PAS (tous les post), ordonnés par datecreate ascendante


# idem que le précédent pour trouver QUE les post qui n'ont PAS de category (sans les champs de category à l'affichage, voir isnull()), en partant de FROM post !


# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category DANS TOUS LES CAS même si le lien N'EXISTE PAS (toutes les category) ordonnés par datecreate ascendante


# idem que le précédent pour trouver QUE les category qui n'ont PAS de post (sans les champs de category à l'affichage, voir isnull()), en partant de FROM post !


#
# JOINTURES M2M + one to many (1 ou plusieures o2m)
# !!! 2 jointures many to many pourront mener à des comportements inattendus! A éviter
#

# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user SEULEMENT si le lien existe (que les données en INNER), AVEC l'id (renommé en idcategory) et title (renommé en titlecategory) de la table category SEULEMENT si le lien existe (que les données en INNER), ordonnés par datecreate ascendante


# Le many to many permet d'avoir des doublons, pour éviter cela, on peut utiliser GROUP BY (sur post) et GROUP_CONCAT (sur les champs de category) (en mysql er mariadb)
# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user SEULEMENT si le lien existe (que les données en INNER), AVEC l'id concaténé avec la , (renommé en idcategory) et title concaténé avec '||0||' (renommé en titlecategory) de la table category SEULEMENT si le lien existe (que les données en INNER), ordonnés par datecreate ascendante groupé par la clef primaire de post


# Séléction des champs id, title et datecreate de la table post, AVEC l'id (renommé en iduser) et userscreen de la table user AUSSI si le lien existe (que les données en LEFT, tous les articles), AVEC l'id concaténé avec la , (renommé en idcategory) et title concaténé avec '||0||' (renommé en titlecategory) de la table category AUSSI si le lien existe (tous les articles), ordonnés par datecreate ascendante
