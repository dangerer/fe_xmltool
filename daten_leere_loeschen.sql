SELECT group_concat(cast(el.uid as ids)) from tx_exabiscompetences_educationlevels el LEFT JOIN 
tx_exabiscompetences_schooltypes st ON el.uid=st.elid
where el.title="" and isnull(st.uid)

SELECT group_concat(cast(el.uid as char)) as ids from tx_exabiscompetences_educationlevels el LEFT JOIN 
tx_exabiscompetences_schooltypes st ON el.uid=st.elid
where el.title="" and isnull(st.uid)

SELECT group_concat(cast(top.uid as binary)) as ids from tx_exabiscompetences_topics top LEFT JOIN 
tx_exabiscompetences_descriptors_topicid_mm mm ON top.uid=mm.uid_foreign
where top.title="" and isnull(mm.uid_foreign)

SELECT group_concat(cast(descr.uid as binary)) as ids from tx_exabiscompetences_descriptors descr LEFT JOIN 
tx_exabiscompetences_examples_descrid_mm mm ON descr.uid=mm.uid_foreign
where descr.title="" and isnull(mm.uid_foreign)

SELECT group_concat(cast(ex.uid as binary)) as ids from tx_exabiscompetences_examples ex LEFT JOIN 
tx_exabiscompetences_examples_descrid_mm mm ON ex.uid=mm.uid_local
where ex.title="" and isnull(mm.uid_local)

79,80,118