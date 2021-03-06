#   C i r n o  
  
 < i m g   s r c = " h t t p s : / / i . i b b . c o / m D 1 S Y h 0 / 2 0 0 p x . p n g "   s t y l e = " f l o a t : l e f t " > < / i m g >  
  
 C i r n o - p h p   i s   a   l i g h t - w e i g h t   p h p   a p i   f r a m e w o r k   f o r   r a p i d   d e v e l o p m e n t ,   b a s e d   o n   F l i g h t   a n d   M e d o o ,   w i t h   a p i D o c   s u p p o r t .  
  
 # #   F e a t u r e s  
  
 C i r n o - p h p   h e l p s   c r e a t e   a p i   w i t h   m a n y   * * A U T O M A T I C A L * *   o p e r a t i o n s ,   w h i c h   s a v e s   y o u r   m a s s i v e   t i m e .    
  
 1 .   A u t o   g e n e r a t e   * * h t t p   m e t h o d s ,   r o u t e s * *   i n t o   f i l e s .  
 2 .   A u t o   * * p a r a m e t e r s * *   b a s i c   f i l t e .  
 3 .   A u t o   * * u s e r   p e r m i s s i o n s * *     f i l t e  
  
 L e t ' s   t a k e   a n   e x a m p l e :  
  
 C r e a t e   a   f i l e   ` s r c / A p i / C a l c u l a t o r . p h p `  
  
 ` ` ` p h p  
 < ? p h p  
 n a m e s p a c e   A p p \ A p i ;  
 c l a s s   C a l c u l a t o r  
 {  
           / * *  
           *   @ a p i   { g e t }   / c a l c / s q r t   C a l c u l a t e   s q r t ( n u m )  
           *   @ a p i N a m e   s q r t  
           *   @ a p i G r o u p   C a l c u l a t o r  
           *   @ a p i V e r s i o n   0 . 2  
           *   @ a p i P e r m i s s i o n   n o n e  
           *   @ a p i P a r a m   { i n t e g e r { 0 - 2 0 0 } }   n u m   T h e   n u m b e r   t o   b e   c a l c u l a t e d .  
           *   @ a p i S u c c e s s   { i n t e g e r }   r e s u l t   T h e   r e s u l t   o f   c a l c u l a t i o n .  
           *   @ a p i S u c c e s s E x a m p l e  
           *     {  
           *     " n o n c e " :   " c 6 5 a 7 e e b 9 f 7 e a 4 d b 2 8 2 c 2 e b a 6 7 4 e 3 7 0 5 f f 8 7 4 7 a c "  
           *     }  
           * /  
         p u b l i c   f u n c t i o n   m y S q r t ( )  
         {  
                 $ n u m   =   \ A p p : : $ a p i - > r e q u e s t ( ) - > q u e r y - > n u m ;  
                 \ A p p : : $ a p i - > j s o n ( [  
                         " r e s u l t "   = >   $ n u m   *   $ n u m  
                 ] ) ;  
         }  
 }  
 ` ` `  
  
 A n d   e x e c u t e :  
  
 ` ` ` s h e l l  
 $   p h p   g e n e r a t o r . p h p   r u n  
 ` ` `  
  
 Y o u   c a n   s e e   s o m e   f i l e s   g e n e r a t e d :  
  
 ` ` ` p h p  
 / / f i l e :   s r c / c o m m o n / r o u t e . p h p  
 < ? p h p  
 $ a p i W e l c o m e   =   n e w   \ A p p \ A p i \ W e l c o m e ( ) ;  
 F l i g h t : : r o u t e ( ' G E T   / ' ,   a r r a y ( $ a p i W e l c o m e ,   ' i n d e x ' ) ) ;  
 ` ` `  
  
 ` ` ` p h p  
 / / f i l e :   s r c / c o m m o n / r u l e . p h p  
 r e t u r n   [          
         ' / c a l c / s q r t '   = >   [  
                 ' p a r a m '   = >   [  
                         ' n u m '   = >   [  
                                 ' t y p e '   = >   ' i n t e g e r e g e r ' ,  
                                 ' m i n '   = >   0 ,  
                                 ' m a x '   = >   2 0 0 ,  
                                 ' r e q u i r e d '   = >   t r u e ,  
                         ] ,  
                 ] ,  
         ] ,  
 ] ;  
 ` ` `  
  
 ` ` ` p h p  
 / / f i l e :   s r c / c o m m o n / p e r m i s s i o n . p h p  
 < ? p h p  
 r e t u r n [  
         ' / c a l c / s q r t ' = > ' n o n e ' ,  
 ] ;  
 ` ` `  
  
 A n d   t h e n   w e   g o   t o   ` h t t p : / / 1 2 7 . 0 . 0 . 1 : 8 0 8 0 / c a l c / s q r t ? n u m = 1 0 `  
  
 W e   g o t :  
  
 ` ` ` j s o n  
 {  
     " r e s u l t " :   1 0 0  
 }  
 ` ` `  
  
 W h a t   i f   ` h t t p : / / 1 2 7 . 0 . 0 . 1 : 8 0 8 0 / c a l c / s q r t ? n u m = 1 0 0 0 ` ?  
  
 ` ` ` j s o n  
 {  
     " m e s s a g e " :   " P a r a m e t e r   ` n u m `   i s   e x p e c t e d   t o   b e   l e s s   t h a n   2 0 0 .   "  
 }  
 ` ` `  
  
 A n d   w h a t   i f   ` h t t p : / / 1 2 7 . 0 . 0 . 1 : 8 0 8 0 / c a l c / s q r t ? s s = 1 0 0 0 ` ?  
  
 ` ` ` j s o n  
 {  
     " m e s s a g e " :   " M i s i n g   r e q u i r e d   p a r a m e t e r . "  
 }  
 ` ` `  
  
 A n d   ` h t t p : / / 1 2 7 . 0 . 0 . 1 : 8 0 8 0 / c a l c / s q r t ? n u m = ` ?  
  
 ` ` ` j s o n  
 {  
     " m e s s a g e " :   " P a r a m e t e r   ` n u m `   i s   g i v e n   b u t   i t   h a s   e m p t y   v a l u e . "  
 }  
 ` ` `  
  
  
  
 A s   y o u   c a n   s e e ,   w h a t   y o u   n e e d   t o   d o   i s   j u s t   w r i t e   A P I   c o d e .   A P I   c o m m e n t s   w i l l   b e   p a r s e d .  
  
 #   A c e s o - B a c k e n d  
 # aceso-basic-backend
