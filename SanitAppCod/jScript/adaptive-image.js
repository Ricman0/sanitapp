/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

document.cookie='resolution='+Math.max(screen.width,screen.height)
                    +("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")
                    +'; path=/';

