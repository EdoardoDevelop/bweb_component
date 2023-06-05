( function( blocks, element, components) {

  var el = element.createElement,
  registerBlockType = blocks.registerBlockType,
  InspectorControls = wp.blockEditor.InspectorControls,
  Fragment = element.Fragment,
  useBlockProps = wp.blockEditor.useBlockProps,
  AlignmentMatrixControl = components.__experimentalAlignmentMatrixControl,
  FocalPointPicker = components.FocalPointPicker,
  MediaUpload =  wp.blockEditor.MediaUpload,
  MediaUploadCheck =  wp.blockEditor.MediaUploadCheck,
  ColorPalette = components.ColorPalette 
  ToolbarButton = components.ToolbarButton,
  Modal = components.Modal,
  useState = element.useState,
  BlockControls = wp.blockEditor.BlockControls,
  TabPanel = components.TabPanel,
  Toolbar = components.Toolbar,
  ToolbarGroup  = components.ToolbarGroup,
  ToolbarDropdownMenu = components.ToolbarDropdownMenu,
  PanelBody = components.PanelBody,
  SelectControl = components.SelectControl,
  CheckboxControl = components.CheckboxControl,
  Button = components.Button,
  UnitControl = components.__experimentalUnitControl,
  RadioControl = components.RadioControl,
  InnerBlocks = wp.blockEditor.InnerBlocks;

  function MyMediaUploader({ mediaIDs, onSelect, toolbar = false }) {
    return el(MediaUploadCheck, null, el(MediaUpload, {
      onSelect: onSelect,
      allowedTypes: [ 'image' ],
      value: mediaIDs,
      render: ({
        open
      }) => el(Button, {
        icon: 'insert',
        variant: "secondary",
        onClick: open,
        className: toolbar ? '' : "button button-large"
      }, 'Aggiungi/Modifica'),
      gallery: true,
      multiple: true
    }));
  }

  function alignText(v){
    var alignText = {}; 
    switch(v) {
      case 'top left':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '20px',
          left: '30px',
          transform:'translate(0,0)'
        };
        break;
      case 'top center':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '20px',
          left: '50%',
          transform:'translateX(-50%)'
        };
        break;
      case 'top right':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '20px',
          right: '30px',
          transform:'translate(0,0)'
        };
        break;
      case 'center left':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '50%',
          left: '30px',
          transform:'translateY(-50%)'
        };
        break;
      case 'center center':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '50%',
          left: '50%',
          transform:'translate(-50%,-50%)'
        };
        break;
      case 'center right':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '50%',
          right: '30px',
          transform:'translateY(-50%)'
        };
      break;
      case 'bottom left':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          bottom: '20px',
          left: '30px',
          transform:'translate(0,0)'
        };
        break;
      case 'bottom center':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          bottom: '20px',
          left: '50%',
          transform:'translateX(-50%)'
        };
        break;
      case 'bottom right':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          bottom: '20px',
          right: '30px',
          transform:'translate(0,0)'
        };
        break;
    }
    return alignText;
  }
  
    //console.log(cpt);
	registerBlockType( 'bc/slide', {
    apiVersion: 2,
    title: 'BC Slide',
    icon: 'slides',
    category: 'bweb-component',
    
    "supports": {
      "align": [ 'wide', 'full' ]
    },
    attributes: {
      'blockID': {
				type: 'string',
        default: '0'
			},
			'mode': {
				type: 'string',
        default: 'slide'
			},
      'valueH': {
        type: 'string',
        default: '500px'
      },
      'Overlaycolor': {
        type: 'string',
        default: 'rgba(0, 0, 0, 0.47)'
      },
      'isTextShow': {
        type: 'boolean',
        default: 1
      },
      'Textalignment': {
        type: 'string',
        default: 'center center'
      },
      'arrowShow':{
        type: 'boolean',
        default: 1
      },
      'pointerShow':{
        type: 'boolean',
        default: 0
      },
      'pointerType':{
        type: 'string',
        default: 'square'
      },
      'enablescript':{
        type: 'boolean',
        default: 0
      },
      
      'images': {
        type: 'array',
        source: 'query',
        selector: '.carousel-item',
        default: [],
  
        // The following means in each .slider-item element in the saved markup,
        // the attribute value is read from the data-id/src/data-thumb attribute
        // of the img element in the .slider-item element. And yes of course, you
        // can change the selector to 'a', '.some-class' or something else.
        query: {
          focalPointX:{
            type: 'string',
            source: 'attribute',
            attribute: 'data-focalpointx',
            selector: 'img',
          },
          focalPointY:{
            type: 'string',
            source: 'attribute',
            attribute: 'data-focalpointy',
            selector: 'img',
          },
          countI: {
            type: 'number',
            source: 'attribute',
            attribute: 'data-count',
            selector: 'img',
          },
          mediaID: {
            type: 'number',
            source: 'attribute',
            attribute: 'data-id',
            selector: 'img',
          },
          mediaURL: {
            type: 'string',
            source: 'attribute',
            attribute: 'src',
            selector: 'img',
          },
          thumbnail: {
            type: 'string',
            source: 'attribute',
            attribute: 'data-thumb',
            selector: 'img',
          },
        },
      },
    },


    edit: function( props ) {
      var blockID = props.attributes.blockID,
      mode = props.attributes.mode,
      valueH = props.attributes.valueH,
      images = props.attributes.images,
      Overlaycolor = props.attributes.Overlaycolor,
      isTextShow = props.attributes.isTextShow,
      Textalignment = props.attributes.Textalignment,
      arrowShow = props.attributes.arrowShow,
      pointerShow = props.attributes.pointerShow,
      enablescript = props.attributes.enablescript,
      pointerType = props.attributes.pointerType;

      const [ isOpen, setOpen ] = useState( false );
      const openModal = () => setOpen(true);
      const closeModal = () => setOpen(false);

      const unitsH = [
          { value: 'px', label: 'px', default: 0 },
          { value: '%', label: '%', default: 10 },
          { value: 'vh', label: 'vh', default: 0 },
      ];

      run_bc_slide();
      const onSelect = items => {
        var countI = 0;
        props.setAttributes({
          images: items.map(item => {
            countI++;
            //console.log(item);
            return {
              focalPointX:"0.5",
              focalPointY:"0.5",
              countI: countI,
              mediaID: parseInt(item.id, 10),
              mediaURL: item.sizes.image_HD.url,
              thumbnail: item.sizes.thumbnail.url
            };
          })
        });
      };
      var blockPropsCarousel = useBlockProps({
        className: 'bc_slide carousel '+mode,
        //'data-id':'bc_slide',
        //'data-ride': 'carousel',
        //'data-interval': 'false',
        style:{'height': valueH}
      });
      
      
      if(blockID==0){
        props.setAttributes({ blockID : blockPropsCarousel.id });
      }
      jQuery('#'+blockPropsCarousel.id).carousel({
        interval: false
      })

      const TEMPLATE = [ 
        [ 'core/heading', { placeholder: 'Enter title...',fontSize: 'large','textColor': 'white' } ],
        [ 'core/paragraph', { placeholder: 'Enter side content...', 'textColor': 'white' } ]
      ];
      
      
      return (
                
        el( Fragment, {},
            
          el( InspectorControls, {},
            el(TabPanel, {
              className: "bcslide-tab-panel",
              tabs: [{
                name: 'images',
                title: 'Immagini',
                className: 'bcslide-tab-images',
                icon: 'format-gallery'
              }, {
                name: 'settings',
                title: 'Impostazioni',
                className: 'bcslide-tab-settings',
                icon: 'admin-generic'
              }, {
                name: 'appearance',
                title: 'Aspetto',
                className: 'bcslide-tab-appearance',
                icon: 'admin-appearance'
              }],
              children: tab => 
              {
                if(tab.name=='images'){
                  return el('div',{},
                    el(PanelBody,{},
                        el(MyMediaUploader, {
                        mediaIDs: images.map(item => item.mediaID),
                        onSelect: onSelect
                      }),
                      el(Button, {
                        className: "button button-small",
                        onClick: openModal,
                        children: "Posizionamento immagini",
                        style:{
                          "margin-top":"15px"
                        }
                      }),
                      isOpen ?
                      el(Modal, {
                          title: "Posizionamento immagini",
                          onRequestClose: closeModal,
                          children: 
                          images.map(item =>
                            el("div",{
                                className: "item_focalpointpicker"+item.countI,
                                style:{
                                  width: "200px",
                                  display: "inline-block",
                                  margin: "5px"
                                }
                              },
                              el(FocalPointPicker,{
                                url: item.mediaURL,
                                value: {x:Number(item.focalPointX),y:Number(item.focalPointY)},
                                
                                onChange: ( value ) => {
                                  
                                  setTimeout(() => {
                                    document.querySelector('.components-modal__screen-overlay').classList.remove("drag_modal_background");
                                    document.querySelector('.components-modal__frame').classList.remove("drag_modal_background");
                                    document.querySelector('.components-modal__header').classList.remove("drag_modal_opacity");
                                    document.querySelector('.components-modal__content').classList.remove("drag_modal_opacity");
                                    document.querySelectorAll('.components-modal__content > div').forEach(element => {
                                      if(!element.classList.contains("item_focalpointpicker"+item.countI)){
                                        element.classList.remove("drag_modal_opacity");
                                      }else{
                                        element.querySelector('.focal-point-picker__controls').classList.remove("drag_modal_opacity");
                                      }
                                    });
                                  }, 800);
                                  
                                },
                                onDrag: (value) => {
                                  props.setAttributes({
                                    images: images.map(img => {
                                      if(img.mediaURL==item.mediaURL){
                                        img.focalPointX = String(value.x);
                                        img.focalPointY = String(value.y);
                                      }
                                      return img;
                                    })
                                  });
                                  jQuery('#'+blockPropsCarousel.id).carousel(item.countI-1);
                                  document.querySelector('.components-modal__screen-overlay').classList.add("drag_modal_background");
                                  document.querySelector('.components-modal__frame').classList.add("drag_modal_background");
                                  document.querySelector('.components-modal__header').classList.add("drag_modal_opacity");
                                  //document.querySelector('.components-modal__content *').classList.add("drag_modal_opacity");
                                  document.querySelectorAll('.components-modal__content > div').forEach(element => {
                                    if(!element.classList.contains("item_focalpointpicker"+item.countI)){
                                      element.classList.add("drag_modal_opacity");
                                    }else{
                                      element.querySelector('.focal-point-picker__controls').classList.add("drag_modal_opacity");
                                    }
                                    
                                  });
                                }
                              })
                            )
                          )

                      })
                      :null

                    )
                  )
                };
                if(tab.name=='settings'){
                  return el('div',{},
                    el(PanelBody,{title: 'Modalità'},
                      el(SelectControl,{
                        value: mode,
                        options: [
                            {
                                "value": "slide",
                                "label": "Slide"
                            },
                            {
                                "value": "slide carousel-fade",
                                "label": "Fade"
                            }
                        ],
                        onChange: ( value ) => {
                            props.setAttributes( { mode: value } );
                        },
                      })
                    ),
                    
                    el(PanelBody,{title: 'Testo'},
                      el(CheckboxControl,{
                        label: 'Visibile',
                        checked: isTextShow,
                        onChange: ( value ) => {
                            props.setAttributes( { isTextShow: value } );
                        },
                      }),
                      isTextShow ? el(AlignmentMatrixControl, {
                        label: 'Posizione testo',
                        value: Textalignment,
                        onChange: ( value ) => {
                          props.setAttributes( { Textalignment: value } );
                        },
                      }):null
                    ),
                    
                    el(PanelBody,{},
                      el(UnitControl, {
                        label: 'Altezza',
                        className: 'w-UnitControl',
                        value: valueH,
                        units: unitsH,
                        onChange : ( value ) => {
                          props.setAttributes( { valueH: value } );
                        },
                      }),
                      el(CheckboxControl,{
                        label: 'Script separato',
                        checked: enablescript,
                        onChange: ( value ) => {
                            props.setAttributes( { enablescript: value } );
                        },
                      })
                    )
                  )
    
                  
                };
                if(tab.name=='appearance'){
                  return el('div',{},
                    el(PanelBody,{title: 'Frecce'},
                      el(CheckboxControl,{
                        label: 'Abilita',
                        checked: arrowShow,
                        onChange: ( value ) => {
                            props.setAttributes( { arrowShow: value } );
                        },
                      }),

                    ),
                    el(PanelBody,{title: 'Indicatori'},
                      el(CheckboxControl,{
                        label: 'Abilita',
                        checked: pointerShow,
                        onChange: ( value ) => {
                            props.setAttributes( { pointerShow: value } );
                        },
                      }),
                      el(RadioControl, {
                        label: "Tipologia",
                        selected: pointerType,
                        options: [{
                          label: 'Square',
                          value: 'square'
                        },{
                          label: 'Circle',
                          value: 'circle'
                        }],
                        onChange: ( value ) => {
                          props.setAttributes( { pointerType: value } );
                        }
                      })
                    ),
                    el(PanelBody,{title: 'Sovrapposizione'},
                      el(ColorPalette , {
                        label: 'Overlay',
                        value: Overlaycolor,
                        enableAlpha: true,
                        onChange : ( value ) => {
                          props.setAttributes( { Overlaycolor: value } );
                      },
                      })
                    ),
                  )
                };
              }
            }),


          ),
          el(
            BlockControls,
            { key: 'controls' },
            el(ToolbarGroup, {}, 
              el(MyMediaUploader, {
                mediaIDs: images.map(item => item.mediaID),
                onSelect: onSelect,
                toolbar: true
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
                    title: '500px',
                    icon: 'align-wide',
                    onClick : ( value ) => {
                      props.setAttributes( { valueH: '500px' } );
                    }
                  }
                ]
              }),
              isTextShow ? el(ToolbarDropdownMenu,{
                title: 'Posizione testo',
                icon: AlignmentMatrixControl.Icon,
                children: ({
                  onClose
                }) =>
                  el(AlignmentMatrixControl, {
                    value: Textalignment,
                    onChange: ( value ) => {
                      props.setAttributes( { Textalignment: value } );
                    },
                  })
                
              }):null
            ),
          ),

          el("div", blockPropsCarousel, 
            images.length >= 1 ? el("div", {
              className: "carousel-inner"
            }, 
              images.map(item => el("div", 
                {
                  className: item.countI == 1 ? "carousel-item active" : "carousel-item",
                  key: 'image-' + item.mediaID
                }, 
                el("img", 
                  {
                    src: item.mediaURL,
                    style:{
                      "object-position": Number(item.focalPointX) * 100 + "% " + Number(item.focalPointY) * 100 + "%"
                    }
                  }
                )
              )),
              el("div",{
                className: 'carousel-overlay',
                style:{'background-color': Overlaycolor}
              }),
              isTextShow ? el("div",{
                className: 'caption',
                style:alignText(Textalignment)
              },el(InnerBlocks,{
                "title": "Caption",
                template: TEMPLATE,
                allowedBlocks: ['core/paragraph','core/heading','core/button'],
                orientation: "vertical"
                
              })):null,
              arrowShow ? el("a",{
                className : "carousel-control-prev",
                href: "#"+blockPropsCarousel.id,
                role: "button",
                'data-slide': 'prev'
                },el("span",{
                  className : "carousel-control-prev-icon",
                })
              ):null,
              arrowShow ? el("a",{
                className : "carousel-control-next",
                href: "#"+blockPropsCarousel.id,
                role: "button",
                'data-slide': 'next'
                },el("span",{
                  className : "carousel-control-next-icon",
                })
              ):null,
              pointerShow ?  el("ol",{
                  className: "carousel-indicators " + pointerType
                },
                images.map(item => el("li", 
                    {
                      className: item.countI == 1 ? "active" : "",
                      "data-target": "#"+blockPropsCarousel.id,
                      "data-slide-to": item.countI - 1
                    }
                  )
                )
              ):null,

            ) : el("div", {
                style:{
                  display: 'flex',
                  'justify-content': 'center',
                  height: '100%',
                  'align-items': 'center'
                }
              }, el(MyMediaUploader, {
                mediaIDs: images.map(item => item.mediaID),
                onSelect: onSelect,
                toolbar: true
              })
            )
          ),
          
        )
              
      )
    },

    save: function(props) {
      
      var blockPropscarousel = useBlockProps.save({
        className: 'bc_slide carousel '+props.attributes.mode,
        id : props.attributes.blockID,
        'data-ride': 'carousel',
        style:{
          'height': props.attributes.valueH
        }
      });

      
      return el("div", blockPropscarousel, el("div", {
        className: "carousel-inner"
      }, 
        props.attributes.images.map(item => el("div", 
          {
            className:  item.countI == 1 ? "carousel-item active" : "carousel-item",
            key: 'image-' + item.mediaID
          }, 
          el("img", 
            {
              "data-focalpointx": String(item.focalPointX),
              "data-focalpointY": String(item.focalPointY),
              'data-count': item.countI,
              src: item.mediaURL,
              "data-id": item.mediaID,
              "data-thumb": item.thumbnail,
              style:{
                "object-position": Number(item.focalPointX) * 100 + "% " + Number(item.focalPointY) * 100 + "%"
              }
            }
          )
        )),
        el("div",{
          className: 'carousel-overlay',
          style:{'background-color': props.attributes.Overlaycolor}
        }),
        props.attributes.isTextShow ? el("div",{className:'container container-carousel-caption'},el("div",{className:'carousel-caption',style:alignText(props.attributes.Textalignment)},el(InnerBlocks.Content))):null,
        props.attributes.arrowShow ? el("a",{
          className : "carousel-control-prev",
          href: "#"+blockPropscarousel.id,
          role: "button",
          'data-slide': 'prev'
          },el("span",{
            className : "carousel-control-prev-icon",
          })
        ):null,
        props.attributes.arrowShow ? el("a",{
          className : "carousel-control-next",
          href: "#"+blockPropscarousel.id,
          role: "button",
          'data-slide': 'next'
          },el("span",{
            className : "carousel-control-next-icon",
          })
        ):null,
        props.attributes.pointerShow ?  el("ol",{
            className: "carousel-indicators " + props.attributes.pointerType
          },
          props.attributes.images.map(item => el("li", 
              {
                className: item.countI == 1 ? "active" : "",
                "data-target": "#"+blockPropscarousel.id,
                "data-slide-to": item.countI - 1
              }
            )
          )
        ):null
      ),
      props.attributes.enablescript ? el("script",{},"run_bc_slide()"): null
      );
      
    }



  })
  
} )( window.wp.blocks, window.wp.element, window.wp.components );
