
( function( blocks, element, editor, components,serverSideRender) {

    
    
	var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var ServerSideRender = serverSideRender;
    var useBlockProps = wp.blockEditor.useBlockProps;
    //var useEffect = element.useEffect;
    var CheckboxControl = components.CheckboxControl;
    var TextControl = components.TextControl;
    //var RadioControl = components.RadioControl;
    var SelectControl = components.SelectControl;
    var NumberControl = components.__experimentalNumberControl;
    var PanelBody = components.PanelBody,
    PanelRow = components.PanelRow,
    Spinner = components.Spinner;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var Fragment = element.Fragment;
    //console.log(cpt);
	registerBlockType( 'bc/cpt-block', {
        apiVersion: 2,
		title: 'BC Card',
		icon: 'columns',
		category: 'bweb-component',

		attributes: {
			'slug_cpt': {
				type: 'string',
                default: '---'
			},
            'link_card': {
				type: 'string'
			},
            'n_card': {
				type: 'number',
                default: 3
			},
            'n_column': {
				type: 'number',
                default: 3
			},
            's_chk_field': {
				type: 'string'
			},
            'el_title': {
				type: 'string',
                default: 'h2'
			},
            'isImageShow': {
				type: 'boolean',
                default: 1
			},
            'imgSize': {
				type: 'string',
                default: 'medium'
			},
            'isTextShow': {
				type: 'boolean',
                default: 1
			},
            'typeText': {
				type: 'string',
                default: 'excerpt'
			},
            'isButtonShow': {
				type: 'boolean',
                default: 0
			},
            'textButton': {
				type: 'string',
                default: 'Continua a leggere'
			}
         
		},


		edit: function( props ) {
            var blockProps = useBlockProps();
			var slug_cpt = props.attributes.slug_cpt;
			var link_card = props.attributes.link_card;
			var n_card = props.attributes.n_card;
			var n_column = props.attributes.n_column;
			var s_chk_field = props.attributes.s_chk_field;
			var el_title = props.attributes.el_title;
			var isImageShow = props.attributes.isImageShow;
			var imgSize = props.attributes.imgSize;
			var isTextShow = props.attributes.isTextShow;
			var typeText = props.attributes.typeText;
			var isButtonShow = props.attributes.isButtonShow;
			var textButton = props.attributes.textButton;
            
            var ObjCpt = [];
            ObjCpt.push({value: '---', label: '---'});
            for (const [key, value] of Object.entries(cpt)) {
                ObjCpt.push({value: key, label: value.name});
                
            };
			var ObjCf = [];
            ObjCf.push({value: '---', label: '---'});
            for (const [key, value] of Object.entries(cf)) {
                for (const [keyF, valueF] of Object.entries(value.field)) {
                    if(valueF.type == 'checkbox'){
                        ObjCf.push({value: value.namegroup+'_'+valueF.namefield, label: valueF.namefield});
                    }
                }
            };

            var ObjImgSize = [];
            for (const [key, value] of Object.entries(imagesize)) {
                ObjImgSize.push({value: key, label: key});
                //console.log(key)
            };

            

            return (
                
                el( Fragment, {},
                    
                    el( InspectorControls, {},
                        
                        el( PanelBody, { title: 'General', initialOpen: true },
                            el(SelectControl,{
                                label: 'Custom Post',
                                value: slug_cpt,
                                options: ObjCpt,
                                onChange: ( value ) => {
                                    props.setAttributes( { slug_cpt: value } );
                                },
                            }),
                            el(SelectControl,{
                                label: 'Link a',
                                value: link_card,
                                options: [
                                    {
                                        "value": "0",
                                        "label": "Nessuno"
                                    },
                                    {
                                        "value": "post",
                                        "label": "Post"
                                    }
                                ],
                                onChange: ( value ) => {
                                    props.setAttributes( { link_card: value } );
                                },
                            }),
                            el(PanelRow,{},
                                el(NumberControl,{
                                    label: 'Numero colonne',
                                    className: 'input_number',
                                    value: n_column,
                                    min: 1,
                                    max: 4,
                                    labelPosition: 'side',
                                    onChange: ( value ) => {
                                        props.setAttributes( { n_column: parseInt(value) } );
                                    },
                                })
                            ),
                            el(PanelRow,{},
                                el(NumberControl,{
                                    label: 'Numero post',
                                    className: 'input_number',
                                    value: n_card,
                                    min: -1,
                                    max: 8,
                                    labelPosition: 'side',
                                    onChange: ( value ) => {
                                        props.setAttributes( { n_card: parseInt(value) } );
                                    },
                                })
                            ),
                            el(PanelRow,{}),
                            el(SelectControl,{
                                label: 'Compare custom checkbox',
                                value: s_chk_field,
                                options: ObjCf,
                                onChange: ( value ) => {
                                    props.setAttributes( { s_chk_field: value } );
                                },
                            })
                                
                            
                        ),
                        el( PanelBody, { title: 'Immagine', initialOpen: false },
                            el(PanelRow,{},
                                el(CheckboxControl,{
                                    label: 'Immagine Visibile',
                                    checked: isImageShow,
                                    onChange: ( value ) => {
                                        props.setAttributes( { isImageShow: value } );
                                    },
                                    
                                })
                            ),
                            el(PanelRow,{className: isImageShow ? '' : 'component_hidden'},
                                el(SelectControl,{
                                    label: 'Image Size',
                                    value: imgSize,
                                    options: ObjImgSize,
                                    onChange: ( value ) => {
                                        props.setAttributes( { imgSize: value } );
                                    },
                                    //style: {display: isImageShow ? 'none' : 'block'}
                                    
                                }),
                            ),
                        ),
                        el(PanelBody,{title: 'Titolo', initialOpen: false},
                            el(SelectControl,{
                                label: 'tag',
                                value: el_title,
                                options: [
                                    {
                                        "value": "p",
                                        "label": "p"
                                    },
                                    {
                                        "value": "a",
                                        "label": "a (link to post)"
                                    },
                                    {
                                        "value": "h2",
                                        "label": "H2"
                                    },
                                    {
                                        "value": "h3",
                                        "label": "H3"
                                    },
                                    {
                                        "value": "h4",
                                        "label": "H4"
                                    },
                                ],
                                onChange: ( value ) => {
                                    props.setAttributes( { el_title: value } );
                                },
                            }),
                        ),
                        el(PanelBody,{title: 'Testo', initialOpen: false},
                            el(CheckboxControl,{
                                label: 'Visibile',
                                checked: isTextShow,
                                onChange: ( value ) => {
                                    props.setAttributes( { isTextShow: value } );
                                },
                                
                            }),
                        
                            el(PanelBody,{className: isTextShow ? '' : 'component_hidden'},
                                el(SelectControl,{
                                    label: 'Tipo testo',
                                    value: typeText,
                                    options: [
                                        {
                                            "value": "content",
                                            "label": "Content"
                                        },
                                        {
                                            "value": "excerpt",
                                            "label": "Excerpt"
                                        }
                                    ],
                                    onChange: ( value ) => {
                                        props.setAttributes( { typeText: value } );
                                    }
                                    
                                }),
                            ),
                        ),
                        el(PanelBody,{title: 'Pulsante', initialOpen: false},
                            el(CheckboxControl,{
                                label: 'Visibile',
                                checked: isButtonShow,
                                onChange: ( value ) => {
                                    props.setAttributes( { isButtonShow: value } );
                                },
                                
                            }),
                            el(PanelRow,{className: isButtonShow ? '' : 'component_hidden'},
                                el( TextControl, {
                                    label: 'Testo pulsante',
                                    value: textButton,
                                    onChange: ( value ) => {
                                        props.setAttributes( { textButton: value } );
                                    },
                                    style: {'max-width': '100%','display': 'block'}
                                } )
                            )
                        )
                        
         
                    ),
                    
                        
                    el("div", blockProps,
                        el( ServerSideRender, {
                            block: 'bc/cpt-block',
                            attributes: props.attributes
                        } ) 
                        
                        
                      
                    
         
                )
                    )
                
            )

            
		},

		save: function( props ) {   
			
            return null
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.editor, window.wp.components,window.wp.serverSideRender );
