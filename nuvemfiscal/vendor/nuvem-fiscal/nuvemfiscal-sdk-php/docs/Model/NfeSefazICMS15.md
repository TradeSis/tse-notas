# # NfeSefazICMS15

## Propriedades

Nome | Tipo | Descrição | Comentários
------------ | ------------- | ------------- | -------------
**orig** | **int** | Origem da mercadoria:  * 0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;  * 1 - Estrangeira - Importação direta, exceto a indicada no código 6;  * 2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;  * 3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%% e inferior ou igual a 70%%;  * 4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes;  * 5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%%;  * 6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e gás natural;  * 7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CAMEX e gás natural;  * 8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%%. |
**cst** | **string** | Tributção pelo ICMS  * 15 - Tributação monofásica própria e com responsabilidade pela retenção sobre combustíveis |
**q_bc_mono** | **float** | Quantidade tributada. | [optional]
**ad_rem_icms** | **float** | Alíquota ad rem do imposto. |
**v_icms_mono** | **float** | Valor do ICMS próprio. |
**q_bc_mono_reten** | **float** | Quantidade tributada sujeita a retenção. | [optional]
**ad_rem_icms_reten** | **float** | Alíquota ad rem do imposto com retenção. |
**v_icms_mono_reten** | **float** | Valor do ICMS com retenção. |
**p_red_ad_rem** | **float** | Percentual de redução do valor da alíquota ad rem do ICMS. | [optional]
**mot_red_ad_rem** | **int** | Motivo da redução do adrem  * 1 - Transporte coletivo de passageiros  * 9 - Outros | [optional]

[[Voltar à lista de DTOs]](../../README.md#models) [[Voltar à lista de API]](../../README.md#endpoints) [[Voltar ao README]](../../README.md)
