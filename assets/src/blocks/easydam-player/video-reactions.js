/**
 * External dependencies
 */
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import EmojiPicker from 'emoji-picker-react';
import videojs from 'video.js';
import axios from 'axios';
/**
 * WordPress dependencies
 */
import { Icon } from '@wordpress/components';
import { plus, lineSolid } from '@wordpress/icons';

const ReactionControls = ( { children } ) => {
	return ReactDOM.createPortal(
		<>
			{ children }
		</>,
		document.querySelector( '.vjs-progress-control .vjs-progress-holder' ),
	);
};

const VideoReactions = ( { attachmentId, reactionsData } ) => {
	let initialReactions = [];
	try {
		initialReactions = JSON.parse( reactionsData );
	} catch ( error ) {
		initialReactions = [];
	}

	const [ open, setOpen ] = React.useState( false );
	const [ videoDuration, setVideoDuration ] = useState( 0 );
	const [ reactions, setReactions ] = useState( initialReactions );

	const defaultReactions = [ '👍', '😮', '❤️', '😂', '🤩', '🙁', '👎' ];

	useEffect( () => {
		const playerId = 'godam_video_' + attachmentId + '_html5_api';
		const player = videojs( playerId );
		player.addClass( 'godam-attachment' );

		player.on( 'loadedmetadata', () => {
			setVideoDuration( player.duration() );
		} );
	}, [] );

	const handleReactionClick = ( reaction ) => {
		console.log( reaction );

		const url = '/wp-json/easydam/v1/video-reactions';

		const playerId = 'godam_video_' + attachmentId + '_html5_api';

		const player = videojs( playerId );

		const reactionTime = player.currentTime();

		axios.post( url,
			{
				attachment_id: attachmentId,
				reaction,
				reaction_time: reactionTime,
			},
			{
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': window.nonceData.nonce,
				},
			},
		)
			.then( ( response ) => {
				setReactions( [ ...reactions, {
					comment_ID: response.data.reaction_id,
					comment_content: reaction,
					reaction_time: reactionTime,
				} ] );
			} )
			.catch( ( error ) => {
				console.log( error );
			} );
	};

	const toggleEmojiPicker = () => {
		setOpen( ! open );
	};

	useEffect( () => {
		document.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'Escape' ) {
				setOpen( false );
			}
		} );
	}, [] );

	return (
		<>
			<div className="godam-reaction-picker">
				<div className="reaction-bar">
					{
						defaultReactions.map( ( reaction, index ) => {
							return (
								<button key={ index }
									className="reaction-item"
									onClick={ () => handleReactionClick( reaction ) }
								>{ reaction }</button>
							);
						} )
					}
					<button className="emoji-picker-btn"
						onClick={ toggleEmojiPicker }
					><Icon icon={ open ? lineSolid : plus } /></button>
				</div>
				{
					open &&
					<div className="emoji-picker">
						<EmojiPicker
							reactions={ false }
							onEmojiClick={ ( reaction ) => {
								setOpen( false );
								handleReactionClick( reaction.emoji );
							} }
						/>
					</div>
				}
			</div>
			<ReactionControls>
				<div className="godam-reactions">
					<div className="reactions-wrapper">
						{
							reactions.map( ( reaction, index ) => {
								return (
									<div key={ index }
										className="video-reaction-item"
										style={ {
											zIndex: 1000,
											fontSize: '1rem',
											position: 'absolute',
											top: '-2rem',
											left: `${ reaction.reaction_time / videoDuration * 100 }%`,
										} }
									>{ reaction.comment_content }</div>
								);
							} )
						}
					</div>
				</div>
			</ReactionControls>
		</>
	);
};

const rootElement = document.getElementById( 'root-player-reactions' );

if ( rootElement ) {
	const root = ReactDOM.createRoot( rootElement );
	const reactionsData = rootElement?.dataset?.reactions ?? [];

	root.render( <VideoReactions reactionsData={ reactionsData } attachmentId={ rootElement?.dataset?.attachment_id } /> );
}
