( function( blocks, element, editor, components,serverSideRender) {

  var el = element.createElement,
  registerBlockType = blocks.registerBlockType,
  InspectorControls = wp.blockEditor.InspectorControls,
  Fragment = element.Fragment,
  useBlockProps = wp.blockEditor.useBlockProps,
  MediaUpload = wp.blockEditor.MediaUpload,
  MediaUploadCheck = wp.blockEditor.MediaUploadCheck,
  Button = components.Button,
  RichText = wp.blockEditor.RichText,
  AlignmentToolbar = wp.blockEditor.AlignmentToolbar,
  BlockControls = wp.blockEditor.BlockControls,
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
      alignment: {
          type: 'string',
          default: 'none',
      },
    },


    edit: function( props ) {
      var blockProps = useBlockProps({className: "carousel"});
      var media = props.attributes.media;
      var content = props.attributes.content;
      var alignment = props.attributes.alignment;
      var hasImages = false;
      if (typeof(media) !== 'undefined') {
        hasImages = media.length > 0;
        
      }
      const ALLOWED_MEDIA_TYPES = [ 'image' ];

        function onChangeAlignment( newAlignment ) {
            props.setAttributes( {
                alignment:
                    newAlignment === undefined ? 'none' : newAlignment,
            } );
        }   

      return (
                
        el( Fragment, {},
            
          el( InspectorControls, {},

            el(MediaUploadCheck,{},
              el(MediaUpload,{
                onSelect:  ( media ) =>{
                  props.setAttributes( { media: media } );
                },
                multiple: true,
                gallery: true,
                allowedTypes: ALLOWED_MEDIA_TYPES,
                value: media,
                render: ({
                  open
                }) => el(Button, {
                  onClick: open
                }, "Open Media Library")
                
              })
            ),


          ),
                
          el("div", blockProps,
            //props.attributes.media
                                 
            el(InnerBlocks,{
              allowedBlocks: ['core/cover']
            })
            /*hasImages &&
            media.map((image, index) =>
            
              el("div", {'background-image':image.url},
              el(
                  BlockControls,
                  { key: 'controls_'+ index },
                  el( AlignmentToolbar, {
                      value: alignment,
                      onChange: onChangeAlignment,
                  } )
              ),
                  el( RichText, {
                      key: 'RichText_'+index,
                      tagName: 'p',
                      style: { textAlign: alignment },
                      onChange: ( newContent ) =>{props.setAttributes( { content: newContent } )},
                      value: content,
                  } )
                )
              
            )*/
          )
        )
              
      )
    }



  })
  
} )( window.wp.blocks, window.wp.element, window.wp.editor, window.wp.components,window.wp.serverSideRender );