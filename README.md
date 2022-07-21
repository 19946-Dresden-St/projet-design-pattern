
Pour le Singleton : 
     Class du singleton dans Core : DBConnect et elle est utilisée dans la classe SQL
Pour le Builder : 
    Interface dans Core : QueryBuilder
    Class dans Core : MysqlBuilder
    Utilisée dans Core : class = SQL
Pour l'observer : 
    Dans Model Concert et Model User
Pour Prototype : 
    Dans la classe newsletter : fonction __clone
    Utilisée dans controller newsletter : fonction cloneNews


    
Singleton : Cela nous permet de d'avoir une unique connexion à la base de donnée

Builder : Nous utilisons ce pattern pour construire la grande majorité de nos requetes(update,delete...)

Observer : Cela vas nous permettre de notifier les users lorsque nous créons un concert

Prototype: 
Ce design pattern permet de cloner des objets.
Dans notre projet, nous avons un module "newsletter" qui permet, comme son nom l'indique (kappa), d'envoyer des newsletter aux utilisateurs inscrits dans la mailing list.
Nous avons trouvé pertinent de l'implémenter pour ce module car, une fois mis en place, il offre la possibilité au super-administrateur de notre site de "dupliquer" une newsletter directement, sans avoir besoin de copier/coller à la main le titre, le contenu, etc...
