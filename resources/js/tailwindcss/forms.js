module.exports = {
    form: {
        '.input': {
            position: 'relative',
            display: 'inline-block',
            width: '100%',
            height: '40px',
            padding: '10px',
            borderRadius: '12px',
            backgroundColor: '#F5F0F0',
            border: '1px solid #ddd',
            '&:focus': {
                border: '1px solid #991A14',
                outline: 'none'
            },
            '& + .label': {
                position: 'absolute',
                top: '50%',
                left: '10px',
                transform: 'translateY(-50%)',
                backgroundColor: '#F5F0F0',
                padding: '0 5px',
                fontSize: '14px',
                color: '#999'
            },
            '&:focus + .label, &:not(:placeholder-shown) + .label': {
                top: '0',
                transform: 'translateY(-50%) scale(0.8)',
                color: '#991A14'
            }
        },
        '.select': {
            padding: '10px',
            borderRadius: '12px',
            backgroundColor: '#F5F0F0',
            border: '1px solid #ddd',
            '&:focus': {
                border: '1px solid #991A14',
                outline: 'none'
            },
            appearance: 'none', // Hide the default dropdown arrow for a more custom look
            '-webkit-appearance': 'none', // For Safari
            '-moz-appearance': 'none', // For Firefox
            backgroundImage: 'url("data:image/svg+xml;utf8,<svg fill=\'%23991A14\' height=\'20\' viewBox=\'0 0 24 24\' width=\'20\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>")', // Custom dropdown arrow
            backgroundRepeat: 'no-repeat',
            backgroundPositionX: 'calc(100% - 10px)',
            backgroundPositionY: 'center'
        },
        '.textarea': {
            padding: '10px',
            borderRadius: '12px',
            backgroundColor: '#F5F0F0',
            border: '1px solid #ddd',
            '&:focus': {
                border: '1px solid #991A14',
                outline: 'none'
            }
        },


    }
};
