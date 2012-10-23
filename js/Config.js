function Config () {
}

Config.prototype.types = ['array','bigint','boolean','date','datetime','decimal','integer','object','smallint','string','text','time'];


Config.prototype.relationships = [
    {
        internalName: 'OneToOne',
        nameSelf:     'One to One',
        nameOther:    'One to One'
    },
    /*{
        internalName: 'ManyToOne',
        nameSelf:     'Many to One',
        nameOther:    'One to Many'
    },*/
    {
        internalName: 'OneToMany',
        nameSelf:     'One to Many',
        nameOther:    'Many to One'
    },
    /*{
        internalName: 'ManyToMany',
        nameSelf:     'Many to Many',
        nameOther:    'Many to Many'
    },*/
    {
        internalName: 'Inheritance',
        nameSelf:     'Inherits from',
        nameOther:    'Inherited by'
    }
];