								{if $article->articleIsFeatured == '1'}
									{if $templateName == article}
										<li>
											<span class="badge label green">{lang}wcf.article.articleIsFeatured{/lang}</span>
										</li>
									{else}
										<span class="badge label green contentItemBadge contentItemBadgeIsFeatured">{lang}wcf.article.articleIsFeatured{/lang}</span>
									{/if}
								{/if}