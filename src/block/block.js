import './style.scss';
import './editor.scss';

const { apiFetch } = wp;
const { __ } = wp.i18n; 
const { registerBlockType } = wp.blocks; 

registerBlockType( 'tpc/mad-reliable', {
	title: __( 'Mad Reliable' ), 
	icon: 'shield', 
	category: 'common', 
	keywords: [
		__( 'Mad Reliable' ),
		__( 'Uptime Monitor' ),
		__( 'API' ),
  ],
	edit: function( props ) {
    const { attributes, setAttributes } = props;
    if(!attributes.uptimeData) {
      apiFetch( { path: 'uptime/get' } ).then( response => { 
        setAttributes({ 'uptimeData': response.data.monitors });
      });
    }  
    console.log(attributes);
    if(attributes.uptimeData)
      return (
        <table className={ props.className }>
          <tbody>
            <tr>
              <td><strong>Site</strong></td>
              <td><strong>Uptime Percentage</strong></td>
            </tr>
          { attributes.uptimeData && 
            attributes.uptimeData.map((monitor, index) =>
              <tr key={index}>
                <td>{ monitor.friendly_name }</td>
                <td>{ monitor.all_time_uptime_ratio }</td>
              </tr>
            ) 
          }
          </tbody>
        </table>
      )
    return null;
	},

	save: function() {
		return null;
	},
} );
