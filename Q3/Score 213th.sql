select Score from 
  (( select * from students
  ORDER BY 'score' DESC
  limit 213) AS T) 
ORDER BY T.'score' ASC
limit 1;
