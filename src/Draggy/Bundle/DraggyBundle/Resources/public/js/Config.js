function Config () {
}

Config.prototype.types = ['array','bigint','boolean','date','datetime','decimal','integer','object','smallint','string','text','time'];


Config.prototype.relationships = [
    {
        internalName: 'OneToOne',
        nameSelf:     'One to One',
        nameOther:    'One to One',
        optionsName:  'oneToOne'
    },
    {
        internalName: 'ManyToOne',
        nameSelf:     'Many to One',
        nameOther:    'One to Many',
        optionsName:  'manyToOne'
    },
    {
        internalName: 'OneToMany',
        nameSelf:     'One to Many',
        nameOther:    'Many to One',
        optionsName:  'oneToMany'
    },
    {
        internalName: 'ManyToMany',
        nameSelf:     'Many to Many',
        nameOther:    'Many to Many',
        optionsName:  'manyToMany'
    },
    {
        internalName: 'Inheritance',
        nameSelf:     'Inherits from',
        nameOther:    'Inherited by',
        optionsName:  'inheritance'
    }
];