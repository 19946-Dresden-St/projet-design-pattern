
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