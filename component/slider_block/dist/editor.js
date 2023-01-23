( function( blocks, element, editor, components,serverSideRender) {

  var el = element.createElement,
  registerBlockType = blocks.registerBlockType,
  InspectorControls = wp.blockEditor.InspectorControls,
  Fragment = element.Fragment,
  useBlockProps = wp.blockEditor.useBlockProps,
  
  ToolbarButton = components.ToolbarButton,
  useState = element.useState,
  BlockControls = wp.blockEditor.BlockControls,
  Toolbar = components.Toolbar,
  ToolbarGroup  = components.ToolbarGroup,
  ToolbarDropdownMenu = components.ToolbarDropdownMenu,
  PanelBody = components.PanelBody,
  SelectControl = components.SelectControl,
  CheckboxControl = components.CheckboxControl,
  UnitControl = components.__experimentalUnitControl,
  InnerBlocks = wp.blockEditor.InnerBlocks;

  
    //console.log(cpt);
	registerBlockType( 'bc/slide', {
    apiVersion: 2,
    title: 'BC Slide',
    icon: 'slides',
    category: 'bweb-component',
    
    attributes: {
        content: {
          type: 'string',
          source: 'html',
      },
			'mode': {
				type: 'string',
        default: 'horizontal'
			},
      'infiniteLoop': {
        type: 'boolean',
        default: 1
      },
      'auto': {
        type: 'boolean',
        default: 0
      },
      'pager': {
        type: 'boolean',
        default: 0
      },
      'valueH': {
        type: 'string',
        default: '438px'
      },
    },


    edit: function( props ) {
      var mode = props.attributes.mode;
      var infiniteLoop = props.attributes.infiniteLoop;
      var auto = props.attributes.auto;
      var pager = props.attributes.pager;
      var valueH = props.attributes.valueH;
      
      //const [ valueH, setValueH ] = useState( '10px' );

      const unitsH = [
          { value: 'px', label: 'px', default: 0 },
          { value: '%', label: '%', default: 10 },
          { value: 'vh', label: 'vh', default: 0 },
      ];
     
      
      
      return (
                
        el( Fragment, {},
            
          el( InspectorControls, {},
            el( PanelBody, { title: 'Settings', initialOpen: true },

              el(SelectControl,{
                label: 'Mode',
                value: mode,
                options: [
                    {
                        "value": "horizontal",
                        "label": "horizontal"
                    },
                    {
                        "value": "vertical",
                        "label": "vertical"
                    },
                    {
                        "value": "fade",
                        "label": "fade"
                    }
                ],
                onChange: ( value ) => {
                    props.setAttributes( { mode: value } );
                },
              }),

              el(CheckboxControl,{
                label: 'infiniteLoop',
                checked: infiniteLoop,
                onChange: ( value ) => {
                    props.setAttributes( { infiniteLoop: value } );
                },
                
              }),
              el(CheckboxControl,{
                label: 'AutoPlay',
                checked: auto,
                onChange: ( value ) => {
                    props.setAttributes( { auto: value } );
                },
                
              }),
              el(CheckboxControl,{
                label: 'Pager',
                checked: pager,
                onChange: ( value ) => {
                    props.setAttributes( { pager: value } );
                },
                
              }),

              el(PanelBody,{},
                el(UnitControl, {
                  label: 'Altezza',
                  className: 'w-UnitControl',
                  value: valueH,
                  units: unitsH,
                  onChange : ( value ) => {
                    props.setAttributes( { valueH: value } );
                },
                })
              )
              

            ),


          ),
          el(
            BlockControls,
            { key: 'controls' },
            el(ToolbarGroup, {}, 
              el(ToolbarButton, {
                icon: 'insert',
                label: "Aggiungi",
                onClick: () => {
                  document.querySelector('.carousel .wp-block-bc-slide .block-editor-inner-blocks > .block-editor-block-list__layout > .block-list-appender > .block-editor-button-block-appender').click();
                }
              }),
              el(ToolbarDropdownMenu,{
                title: 'Altezza',
                icon: 'editor-expand',
                controls: [
                  {
                    title: 'Altezza piena',
                    icon: 'align-full-width',
                    onClick : ( value ) => {
                      props.setAttributes( { valueH: '100vh' } );
                    }
                  },
                  {
                    title: 'Pixel',
                    icon: 'align-wide',
                    onClick : ( value ) => {
                      props.setAttributes( { valueH: '500px' } );
                    }
                  }
                ]
              })
            ),
          ),
          el("div",{className: "carousel"},
          el("div", useBlockProps(),
                                 
            el(InnerBlocks,{
              allowedBlocks: ['core/cover'],
              orientation: "horizontal"
            }),
            
            
          )),
          
        )
              
      )
    },

    save: function(props) {
      var styleBlock = {
        'height': props.attributes.valueH
      };      
      var blockProps = useBlockProps.save({style:styleBlock});
      //console.log(blockProps);
      return el( 'div', blockProps, 
            el(InnerBlocks.Content)
        
        /*el('div',{className:'carousel-controls'},
        el('span',{className:'prev'}),
        el('span',{className:'next'})
        ),
        el('div',{className: 'carousel-indicators'})*/
      );
    }



  })
  
} )( window.wp.blocks, window.wp.element, window.wp.editor, window.wp.components,window.wp.serverSideRender );

