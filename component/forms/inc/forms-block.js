
( function( blocks, element, editor, components) {

    
    
	var el = element.createElement;
    //var TextControl = components.TextControl;
    //var TextareaControl = components.TextareaControl;
    //var RadioControl = components.RadioControl;
    var SelectControl = components.SelectControl;
    //var PanelBody = components.PanelBody;
    //var InspectorControls = wp.blockEditor.InspectorControls;
    var Fragment = element.Fragment;
    //console.log(forms)
	blocks.registerBlockType( 'bc/forms-block', {
		title: 'BC Forms',
		icon: 'forms',
		category: 'bweb-component',

		attributes: {
			'idforms': {
				type: 'string'
			}/*,
			'templ': {
				type: 'html',
                default: ''
			},
            radioslide: {
				type: 'string',
                default: 'true'
			},*/
		},


		edit: function( props ) {
			var idforms = props.attributes.idforms;
			//var templ = props.attributes.templ;
			//var radioslide = props.attributes.radioslide;
            var myObj = [];
            myObj.push({value: '---', label: '---'});
            for (const [key, value] of Object.entries(forms)) {
                myObj.push({value: key, label: value.name});
                //console.log(value)
            };
			
            return (
                el( Fragment, {},
                    /*el( InspectorControls, {},
                        
                        el( PanelBody, { title: 'Forms', initialOpen: true },
                            el(SelectControl,{
                                label: '',
                                value: idforms,
                                options: myObj,
                                onChange: ( value ) => {
                                    props.setAttributes( { idforms: value } );
                                },
                            }),
                        )
                        
         
                    ),*/
         
                    el("div", {
                        style: {
                            border:'1px solid #000',
                            padding: 30,
                            'text-align': 'center'
                        }
                    }, el(SelectControl,{
                            label: 'Form',
                            value: idforms,
                            labelPosition: 'side',
                            options: myObj,
                            onChange: ( value ) => {
                                props.setAttributes( { idforms: value } );
                            },
                        }),
                    ),
                    
         
                )
            )

            
		},

		save: function( props ) {   
			
            return null
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.editor, window.wp.components );
/*,
                        el( PanelBody, { title: 'Template', initialOpen: true },
         
                            el( TextareaControl, {
                                label: '',
                                type: 'html',
                                value: templ,
                                onChange: ( value ) => {
                                props.setAttributes( { templ: value } );
                                },
                                style: {'max-width': '100%','display': 'block'}
                            } ),
                            el("div", {
                                style: {
                                    'margin-bottom': 30
                                }
                            },'variabili: [image], [permalink], [title], [text], [fulltext]'),
                            
                        ),
                        el( PanelBody, { title: 'Slide', initialOpen: true },

                            el( RadioControl, {
                                label: '',
                                selected: radioslide,
                                options: [
                                    {
                                        label: 'Si',
                                        value: 'true'
                                    },
                                    {
                                        label: 'No',
                                        value: 'false'
                                    }
                                ],
                                onChange: ( value ) => {
                                props.setAttributes( { radioslide: value } );
                                },
                                //style: {'max-width': '80%','display': 'block'}
                            } ),
         
                        ),*/