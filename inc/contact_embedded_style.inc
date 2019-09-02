<style>   
    /* embedded  CSS */
		@media screen and (max-width: 767px){    
		#logo-text 
		{  
		display: none;
		}  

		#display-footer{ 
		display: none;
		}  
        

		}
		div#images{   

		display: flex;

		flex-direction: column; 
		float: right; 
		justify-content: space-around;	 
		margin: 10px;

		}  
    /* Main CSS */    
		main{ 
		background-color: #fff;  
       margin-top: 65px;
       
		}
    /* Body Images CSS */
		#Content-image{ 
		float: right;  

		border: 1px solid #ddd;
		border-radius: 4px;
		padding: 5px; 
		transition: transform .2s;

		}  
		#Content-image:hover {
		-ms-transform: scale(1.5); 
		-webkit-transform: scale(1.5); 
		 transform: scale(1.5); 
		}
		#Content-image-two{   
		float: right;  
		border: 1px solid #ddd;
		border-radius: 4px;
		padding: 5px; 
		transition: transform .2s;
		}   
		#Content-image-two:hover {
		-ms-transform: scale(1.5); 
		-webkit-transform: scale(1.5); 
		transform: scale(1.5); 
		} 

		@media screen and (min-width: 767px){  
		#mob-nav{ 
		display: none;
		} 
	    } 
        .container2 input[type=text], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
        }

      .container2 input[type=submit] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
        }

      .container2 input[type=submit]:hover {
        background-color: #45a049;
       }

      /* Style the container/contact section */
      .container2 {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 10px;
       }

      /* Create two columns that float next to eachother */
      .container2 .column {
        float: left;
        width: 50%;
        margin-top: 6px;
        padding: 20px;
       }

      /* Clear floats after the columns */
      .container2 .row:after {
        content: "";
        display: table;
        clear: both;
      }

      /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
      @media screen and (max-width: 767px) {
        .column, input[type=submit] {
            width: 100%; 
           height: auto;
            margin-top: 0;
      } 
      }
      button#login, button#login1{
      background-color: #666; 
      border: none;
     
      }
</style>